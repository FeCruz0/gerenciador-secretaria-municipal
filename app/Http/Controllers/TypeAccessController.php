<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Services\TypeAccessService;
use App\Services\TypeAccessCreateService;
use App\Services\TypeAccessUpdateService;
use App\Http\Requests\TypeAccessRequest;
use App\Models\TypeAccess;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TypeAccessController extends Controller
{
    public function __construct(
        protected TypeAccessService $typeAccessService,
        protected TypeAccessCreateService $typeAccessCreateService,
        protected TypeAccessUpdateService $typeAccessUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }

        $type_accesses = TypeAccess::with('ombudsmen')->latest()->get();

        return Inertia::render('Ombudsman/AccessIndex', [
            'type_accesses' => $type_accesses,
        ]);
    }

    public function store(
        TypeAccessRequest $request
    ){
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->typeAccessCreateService->create($request->toArray());

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Acesso criado com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao adicionar novo Tipo de Acesso!',
            ]);
        }
    }

    public function show($access_id)
    {
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }

        try{
            $type_accesses = TypeAccess::with('ombudsmen')->latest()->get();
            $access_selected = TypeAccess::findOrFail($access_id);

            return Inertia::render('Ombudsman/AccessIndex', [
                'type_accesses'   => $type_accesses,
                'access_selected' => $access_selected,
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar o Tipo de Acesso!',
            ]);
        }
    }

    public function update(
        TypeAccessRequest $request, $access_id
    ){
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->typeAccessUpdateService->update($request->toArray(), $access_id);

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Acesso editado com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar o Tipo de Acesso!',
            ]);
        }
    }

    public function destroy($access)
    {
        if (! Gate::allows('Deletar Manifestações')) {
            abort(403);
        }

        try{
            $type_access = TypeAccess::findOrFail($access);
            $type_access->delete();

            return redirect()->route('ouvidoria_acessos.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Acesso deletado com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar o Tipo de Acesso!',
            ]);
        }
    }

    //site
    public function select()
    {
        $type_accesses = TypeAccess::all();
        return view('web.ouvidoria_access', compact('type_accesses'));
    }
}
