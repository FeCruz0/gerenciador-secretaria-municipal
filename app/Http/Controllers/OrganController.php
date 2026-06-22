<?php

namespace App\Http\Controllers;

use App\Models\Organ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Enums\Permission;

class OrganController extends Controller
{
    public function index()
    {
        if (! Gate::allows(Permission::MANAGE_ENTITIES->value)) {
            abort(403, 'This action is unauthorized.');
        }

        $organs = Organ::with('parent')->get();
        // Apenas órgãos principais (sem pai) podem ser "pais" para evitar recursão profunda
        $parentCandidates = Organ::whereNull('parent_id')->get();

        return Inertia::render('Organ/Index', [
            'organs' => $organs,
            'parentCandidates' => $parentCandidates,
        ]);
    }

    public function store(Request $request)
    {
        if (! Gate::allows(Permission::MANAGE_ENTITIES->value)) {
            abort(403, 'This action is unauthorized.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'sigla' => 'required|string|max:20',
            'theme_color_hex' => 'nullable|string|size:7|regex:/^#([A-Fa-f0-9]{6})$/',
            'is_active' => 'required|boolean',
            'parent_id' => 'nullable|exists:organs,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['name', 'sigla', 'theme_color_hex', 'is_active', 'parent_id']);
            $data['slug'] = Str::slug($request->name);

            // Evitar loop infinito onde um órgão é pai de si mesmo ou estrutura de 3+ níveis
            if ($request->filled('parent_id')) {
                $parent = Organ::find($request->parent_id);
                if ($parent && $parent->parent_id !== null) {
                    return redirect()->back()->withInput()->with('flash', [
                        'type' => 'error',
                        'message' => 'Um sub-órgão não pode ser selecionado como órgão pai.',
                    ]);
                }
            }

            if ($request->hasFile('logo')) {
                $data['logo_path'] = Storage::disk('public')->put('organs', $request->file('logo'));
            }

            Organ::create($data);

            DB::commit();

            return redirect()->back()->with('flash', [
                'type' => 'success',
                'message' => 'Órgão cadastrado com sucesso!',
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao cadastrar o órgão: ' . $throwable->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        if (! Gate::allows(Permission::MANAGE_ENTITIES->value)) {
            abort(403, 'This action is unauthorized.');
        }

        $organ = Organ::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sigla' => 'required|string|max:20',
            'theme_color_hex' => 'nullable|string|size:7|regex:/^#([A-Fa-f0-9]{6})$/',
            'is_active' => 'required|boolean',
            'parent_id' => 'nullable|exists:organs,id|different:id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['name', 'sigla', 'theme_color_hex', 'is_active', 'parent_id']);
            $data['slug'] = Str::slug($request->name);

            // Restrição de hierarquia de dois níveis
            if ($request->filled('parent_id')) {
                // Não pode ser pai de si mesmo (garantido por different:id)
                // Não pode escolher um pai que já é filho de outro
                $parent = Organ::find($request->parent_id);
                if ($parent && $parent->parent_id !== null) {
                    return redirect()->back()->withInput()->with('flash', [
                        'type' => 'error',
                        'message' => 'Um sub-órgão não pode ser selecionado como órgão pai.',
                    ]);
                }

                // Se este órgão tiver filhos, ele não pode se tornar um filho
                if ($organ->children()->exists()) {
                    return redirect()->back()->withInput()->with('flash', [
                        'type' => 'error',
                        'message' => 'Este órgão possui subsecretarias vinculadas e não pode se tornar uma subsecretaria.',
                    ]);
                }
            }

            if ($request->hasFile('logo')) {
                // Deletar logo antiga se existir
                if ($organ->logo_path) {
                    Storage::disk('public')->delete($organ->logo_path);
                }
                $data['logo_path'] = Storage::disk('public')->put('organs', $request->file('logo'));
            }

            $organ->update($data);

            DB::commit();

            return redirect()->back()->with('flash', [
                'type' => 'success',
                'message' => 'Órgão atualizado com sucesso!',
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao atualizar o órgão: ' . $throwable->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        if (! Gate::allows(Permission::MANAGE_ENTITIES->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try {
            DB::beginTransaction();

            $organ = Organ::findOrFail($id);

            if ($organ->logo_path) {
                Storage::disk('public')->delete($organ->logo_path);
            }

            // Nota: parent_id na tabela organs tem constraint nullOnDelete(),
            // então os filhos automaticamente ficarão com parent_id = null.
            $organ->delete();

            DB::commit();

            return redirect()->back()->with('flash', [
                'type' => 'success',
                'message' => 'Órgão excluído com sucesso!',
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao excluir o órgão: ' . $throwable->getMessage(),
            ]);
        }
    }
}
