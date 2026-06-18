<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Services\RevenueTypeService;
use App\Services\RevenueTypeCreateService;
use App\Services\RevenueTypeUpdateService;
use App\Http\Requests\RevenueTypeRequest;
use App\Models\RevenueType;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class RevenueTypeController extends Controller
{
    public function __construct(
        protected RevenueTypeService $revenueTypeService,
        protected RevenueTypeCreateService $revenueTypeCreateService,
        protected RevenueTypeUpdateService $revenueTypeUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Receitas')) {
            abort(403);
        }

        $revenue_types = RevenueType::with('revenues')->latest()->get();

        return Inertia::render('Revenue/TypeIndex', [
            'revenue_types' => $revenue_types,
        ]);
    }

    public function store(
        RevenueTypeRequest $request
    ){
        if (! Gate::allows('Editar Receitas')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->revenueTypeCreateService->create($request->toArray());

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Receita criado com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao adicionar novo Tipo de Receita!',
            ]);
        }
    }

    public function show($type_id)
    {
        if (! Gate::allows('Editar Receitas')) {
            abort(403);
        }

        try{
            $revenue_types = RevenueType::with('revenues')->latest()->get();
            $type_selected = RevenueType::findOrFail($type_id);

            return Inertia::render('Revenue/TypeIndex', [
                'revenue_types'  => $revenue_types,
                'type_selected'  => $type_selected,
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar o Tipo de Receita!',
            ]);
        }
    }

    public function update(
        RevenueTypeRequest $request, $type_id
    ){
        if (! Gate::allows('Editar Receitas')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->revenueTypeUpdateService->update($request->toArray(), $type_id);

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Receita editado com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar o Tipo de Receita!',
            ]);
        }
    }

    public function destroy($type)
    {
        if (! Gate::allows('Editar Receitas')) {
            abort(403);
        }

        try{
            $revenue_type = RevenueType::findOrFail($type);
            $revenue_type->delete();

            return redirect()->route('receita_tipos.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Receita excluído com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar o Tipo de Receita!',
            ]);
        }
    }
}
