<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Services\TypeExpenseService;
use App\Services\TypeExpenseCreateService;
use App\Services\TypeExpenseUpdateService;
use App\Http\Requests\TypeExpenseRequest;
use App\Models\TypeExpense;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TypeExpenseController extends Controller
{
    public function __construct(
        protected TypeExpenseService $typeExpenseService,
        protected TypeExpenseCreateService $typeExpenseCreateService,
        protected TypeExpenseUpdateService $typeExpenseUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }

        $type_expenses = TypeExpense::with('expenses')->latest()->get();

        return Inertia::render('Expense/TypeIndex', [
            'type_expenses' => $type_expenses,
        ]);
    }

    public function store(
        TypeExpenseRequest $request
    ){
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->typeExpenseCreateService->create($request->toArray());

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Despesa criado com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao adicionar novo Tipo de Despesa!',
            ]);
        }
    }

    public function show($type_id)
    {
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }

        try{
            $type_expenses = TypeExpense::with('expenses')->latest()->get();
            $type_selected = TypeExpense::findOrFail($type_id);

            return Inertia::render('Expense/TypeIndex', [
                'type_expenses'  => $type_expenses,
                'type_selected'  => $type_selected,
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar o Tipo de Despesa!',
            ]);
        }
    }

    public function update(
        TypeExpenseRequest $request, $type_id
    ){
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->typeExpenseUpdateService->update($request->toArray(), $type_id);

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Despesa editado com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar o Tipo de Despesa!',
            ]);
        }
    }

    public function destroy($type)
    {
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }

        try{
            $type_expense = TypeExpense::findOrFail($type);
            $type_expense->delete();

            return redirect()->route('despesa_tipos.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Despesa excluído com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar o Tipo de Despesa!',
            ]);
        }
    }
}
