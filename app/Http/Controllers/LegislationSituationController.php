<?php

namespace App\Http\Controllers;

use App\Models\LegislationSituation;
use App\Http\Requests\LegislationSituationRequest;
use App\Models\Unit;
use App\Services\LegislationSituationService;
use App\Services\LegislationSituationCreateService;
use App\Services\LegislationSituationUpdateService;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LegislationSituationController extends Controller
{
    public function __construct(
        protected LegislationSituationService $legislationSituationService,
        protected LegislationSituationCreateService $legislationSituationCreateService,
        protected LegislationSituationUpdateService $legislationSituationUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $legislation_situations = LegislationSituation::with('legislations')->latest()->get();
            
            return Inertia::render('LegislationSituation/Index', compact('unit', 'legislation_situations'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao procurar as Situações Cadastradas!'
            ]);
        }
    }

    public function store(LegislationSituationRequest $request)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $fileData = array_merge(
                $request->toArray(),
                [
                    'active'  => 1
                ]
            );
            $this->legislationSituationCreateService->create($fileData);
            
            DB::commit();
            
            return redirect('/legislacao_situacoes')->with('flash', [
                'type' => 'success',
                'message' => 'Situação criada com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao cadastrar!'
            ]);
        }
    }

    public function show($situation_id)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $legislation_situations = LegislationSituation::with('legislations')->latest()->get();
            $situation_selected = $this->legislationSituationService->show($situation_id);
            
            return Inertia::render('LegislationSituation/Show', compact('situation_selected', 'legislation_situations', 'unit'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao buscar a situação!'
            ]);
        }
    }

    public function update(LegislationSituationRequest $request, $situation_id)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->legislationSituationUpdateService->update($request->toArray(), $situation_id);
            
            DB::commit();
            
            return redirect('/legislacao_situacoes/' . $situation_id)->with('flash', [
                'type' => 'success',
                'message' => 'Situação editada com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao editar!'
            ]);
        }
    }

    public function destroy($legislation_situation)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $situation = LegislationSituation::find($legislation_situation);
            $situation->delete();
            
            return redirect('/legislacao_situacoes')->with('flash', [
                'type' => 'success',
                'message' => 'Situação deletada com sucesso!'
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao deletar a situação!'
            ]);
        }
    }
}
