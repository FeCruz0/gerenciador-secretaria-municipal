<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use App\Services\OrganizationService;
use App\Services\OrganizationCreateService;
use App\Services\OrganizationUpdateService;
use App\Http\Requests\OrganizationRequest;
use App\Models\Unit;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $organizationService,
        protected OrganizationCreateService $organizationCreateService,
        protected OrganizationUpdateService $organizationUpdateService,
    ){}

    public function index()
    {
        /*if (! Gate::allows('Ver e Listar Organizações')) {
            abort(403);
        }*/

        $unit = Unit::where('web', true)->first();
        $organizations = $this->organizationService->get();

        return Inertia::render('Organization/Index', [
            'unit'          => $unit,
            'organizations' => $organizations,
        ]);
    }

    public function store(
        OrganizationRequest $request
    ){
        /*if (! Gate::allows('Criar Organizações')) {
            abort(403);
        }*/
        
        try {
            DB::beginTransaction();
            $this->organizationCreateService->create($request->toArray());

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Organização criada com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao adicionar nova organização!',
            ]);
        }
    }

    public function update(
        OrganizationRequest $request, $organization_id
    ){
        /*if (! Gate::allows('Editar Organizações')) {
            abort(403);
        }*/
        
        try {
            DB::beginTransaction();
            $this->organizationUpdateService->update($request->toArray(), $organization_id);

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Organização editada com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar a Organização!',
            ]);
        }
    }

    public function show($organization_id)
    {
        /*if (! Gate::allows('Editar Organizações')) {
            abort(403);
        }*/

        try{
            $unit = Unit::where('web', true)->first();
            $organizations = $this->organizationService->get();
            $organization_selected = $this->organizationService->show($organization_id);

            return Inertia::render('Organization/Index', [
                'unit'                  => $unit,
                'organizations'         => $organizations,
                'organization_selected' => $organization_selected,
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar a Organização!',
            ]);
        }
    }

    public function destroy($organization)
    {
        /*if (! Gate::allows('Deletar Organizaçãos')) {
            abort(403);
        }*/

        try{
            $organizationModel = Organization::findOrFail($organization);
            $organizationModel->delete();

            return redirect()->route('organizacoes.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Organização deletada com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar a Organização!',
            ]);
        }
    }
}
