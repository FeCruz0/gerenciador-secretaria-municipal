<?php

namespace App\Http\Controllers;

use App\Http\Requests\OccupationRequest;
use App\Models\City;
use App\Models\Departament;
use App\Models\Occupation;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Services\OccupationService;
use App\Services\OccupationCreateService;
use App\Services\OccupationUpdateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class OccupationController extends Controller
{
    public function __construct(
        protected OccupationService $occupationService,
        protected OccupationCreateService $occupationCreateService,
        protected OccupationUpdateService $occupationUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Ocupações')) {
            abort(403);
        }

        $unit = Unit::where('web', true)->first();
        $departaments = Departament::all();
        $occupations = $this->occupationService->get();

        return Inertia::render('Occupation/Index', [
            'unit'         => $unit,
            'occupations'  => $occupations,
            'departaments' => $departaments,
        ]);
    }

    public function store(
        OccupationRequest $request
    ){
        if (! Gate::allows('Criar Ocupações')) {
            abort(403);
        }

        try {
            DB::beginTransaction();
            $this->occupationCreateService->create($request->toArray());

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Ocupação criada com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao adicionar nova ocupação!',
            ]);
        }
    }

    public function show($occupation_id)
    {
        if (! Gate::allows('Ver e Listar Ocupações')) {
            abort(403);
        }

        try{
            $unit = Unit::where('web', true)->first();
            $occupations = $this->occupationService->get();
            $departaments = Departament::all();
            $occupation_selected = $this->occupationService->show($occupation_id);

            return Inertia::render('Occupation/Index', [
                'unit'                 => $unit,
                'occupations'          => $occupations,
                'departaments'         => $departaments,
                'occupation_selected'  => $occupation_selected,
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar a ocupação!',
            ]);
        }
    }

    public function update(
        OccupationRequest $request, $occupation_id
    ){
        if (! Gate::allows('Editar Ocupações')) {
            abort(403);
        }

        try {
            DB::beginTransaction();
            $this->occupationUpdateService->update($request->toArray(), $occupation_id);

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Ocupação editada com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar a ocupação!',
            ]);
        }
    }

    public function destroy($occupation)
    {
        if (! Gate::allows('Deletar Ocupações')) {
            abort(403);
        }

        try{
            $occupationModel = Occupation::findOrFail($occupation);
            $occupationModel->delete();

            return redirect()->route('ocupacoes.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Ocupação deletada com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar a ocupação!',
            ]);
        }
    }
}
