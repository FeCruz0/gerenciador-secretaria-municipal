<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Models\HomeModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class HomeModuleController extends Controller
{
    public function index()
    {
        if (! Gate::allows(Permission::MANAGE_HOME_MODULES->value)) {
            abort(403, 'This action is unauthorized.');
        }

        $modules = HomeModule::orderBy('order', 'asc')->get();

        return Inertia::render('HomeModules/Index', [
            'modules' => $modules,
        ]);
    }

    public function update(Request $request, HomeModule $homeModule)
    {
        if (! Gate::allows(Permission::MANAGE_HOME_MODULES->value)) {
            abort(403, 'This action is unauthorized.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'is_enabled' => 'required|boolean',
        ]);

        $homeModule->update($validated);

        flash('Módulo atualizado com sucesso!')->success();

        return redirect()->back();
    }

    public function updateOrder(Request $request)
    {
        if (! Gate::allows(Permission::MANAGE_HOME_MODULES->value)) {
            abort(403, 'This action is unauthorized.');
        }

        $validated = $request->validate([
            'modules' => 'required|array',
            'modules.*.id' => 'required|integer|exists:home_modules,id',
            'modules.*.order' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            foreach ($validated['modules'] as $item) {
                HomeModule::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            DB::commit();
            flash('Ordem dos módulos atualizada com sucesso!')->success();
        } catch (\Exception $e) {
            DB::rollBack();
            flash('Erro ao atualizar a ordem dos módulos.')->error();
        }

        return redirect()->back();
    }
}
