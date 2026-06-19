<?php

namespace App\Http\Controllers;

use App\Models\ShortcutWeb;
use App\Services\ShortcutWebService;
use App\Services\ShortcutWebCreateService;
use App\Services\ShortcutWebUpdateService;
use App\Http\Requests\ShortcutWebRequest;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class ShortcutWebController extends Controller
{
    public function __construct(
        protected ShortcutWebService $shortcutWebService,
        protected ShortcutWebCreateService $shortcutWebCreateService,
        protected ShortcutWebUpdateService $shortcutWebUpdateService,
    ){}

    public function index()
    {
        try {
            $unit = Unit::where('web', true)->first();
            $shortcut_webs = ShortcutWeb::all();
            
            return Inertia::render('ShortcutWeb/Index', compact('shortcut_webs', 'unit'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao procurar os Atalhos Cadastrados!'
            ]);
        }
    }

    public function store(ShortcutWebRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'image_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $path_image_icon = Storage::disk('shortcutweb')->put('large', $request->file('image_icon'));

            $shortcutData = array_merge(
                $request->toArray(),
                [
                    'img_url'  => $path_image_icon
                ]
            );

            $this->shortcutWebCreateService->create($shortcutData);
           
            DB::commit();
            return redirect('/web_atalhos')->with('flash', [
                'type' => 'success',
                'message' => 'Atalho criado com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao cadastrar!'
            ]);
        }
    }

    public function show($shortcutWeb_id)
    {
        try {
            $shortcut_webs = ShortcutWeb::all();
            $shortcut_web_selected = $this->shortcutWebService->show($shortcutWeb_id);
            $unit = Unit::where('web', true)->first();
            
            return Inertia::render('ShortcutWeb/Show', compact('shortcut_web_selected', 'shortcut_webs', 'unit'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao buscar o Atalho!'
            ]);
        }
    }

    public function update(ShortcutWebRequest $request, $shortcutWeb_id)
    {
        try {
            DB::beginTransaction();

            if (isset($request['image_icon'])) {
                $request->validate([
                    'image_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                $path_image_icon = Storage::disk('shortcutweb')->put('large', $request->file('image_icon'));

                $shortcutData = array_merge(
                    $request->toArray(),
                    [
                        'img_url'  => $path_image_icon
                    ]
                );

                $this->shortcutWebUpdateService->update($shortcutData, $shortcutWeb_id);
            } else {
                $this->shortcutWebUpdateService->update($request->toArray(), $shortcutWeb_id);
            }

            DB::commit();
            return redirect('/web_atalhos/' . $shortcutWeb_id)->with('flash', [
                'type' => 'success',
                'message' => 'Atalho editado com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao editar!'
            ]);
        }
    }

    public function destroy($shortcutWeb)
    {
        try {
            $for_delete = ShortcutWeb::find($shortcutWeb);
            $for_delete->delete();
            
            return redirect('/web_atalhos')->with('flash', [
                'type' => 'success',
                'message' => 'Atalho deletado com sucesso!'
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao deletar o Atalho!'
            ]);
        }
    }
}
