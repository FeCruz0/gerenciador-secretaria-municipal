<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Services\TypeRequestService;
use App\Services\TypeRequestCreateService;
use App\Services\TypeRequestUpdateService;
use App\Http\Requests\TypeRequestRequest;
use App\Models\TypeRequest;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TypeRequestController extends Controller
{
    public function __construct(
        protected TypeRequestService $typeRequestService,
        protected TypeRequestCreateService $typeRequestCreateService,
        protected TypeRequestUpdateService $typeRequestUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }

        $type_requests = TypeRequest::with('ombudsmen')->latest()->get();

        return Inertia::render('Ombudsman/RequestIndex', [
            'type_requests' => $type_requests,
        ]);
    }

    public function store(
        TypeRequestRequest $request
    ){
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->typeRequestCreateService->create($request->toArray());

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Solicitação criado com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao adicionar novo Tipo de Solicitação!',
            ]);
        }
    }

    public function show($request_id)
    {
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }

        try{
            $type_requests = TypeRequest::with('ombudsmen')->latest()->get();
            $request_selected = TypeRequest::findOrFail($request_id);

            return Inertia::render('Ombudsman/RequestIndex', [
                'type_requests'    => $type_requests,
                'request_selected' => $request_selected,
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar o Tipo de Solicitação!',
            ]);
        }
    }

    public function update(
        TypeRequestRequest $request, $request_id
    ){
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->typeRequestUpdateService->update($request->toArray(), $request_id);

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Solicitação editado com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar o Tipo de Solicitação!',
            ]);
        }
    }

    public function destroy($request)
    {
        if (! Gate::allows('Editar Manifestações')) {
            abort(403);
        }

        try{
            $type_request = TypeRequest::findOrFail($request);
            $type_request->delete();

            return redirect()->route('ouvidoria_requisicoes.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Tipo de Solicitação excluído com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar o Tipo de Solicitação!',
            ]);
        }
    }
}
