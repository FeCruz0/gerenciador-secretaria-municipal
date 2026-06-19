<?php

namespace App\Http\Controllers;

use App\Models\LegislationSubject;
use App\Http\Requests\LegislationSubjectRequest;
use App\Models\Unit;
use App\Services\LegislationSubjectService;
use App\Services\LegislationSubjectCreateService;
use App\Services\LegislationSubjectUpdateService;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LegislationSubjectController extends Controller
{
    public function __construct(
        protected LegislationSubjectService $legislationSubjectService,
        protected LegislationSubjectCreateService $legislationSubjectCreateService,
        protected LegislationSubjectUpdateService $legislationSubjectUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $legislation_subjects = LegislationSubject::with('legislations')->latest()->get();
            
            return Inertia::render('LegislationSubject/Index', compact('unit', 'legislation_subjects'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao procurar os Assuntos Cadastrados!'
            ]);
        }
    }

    public function store(LegislationSubjectRequest $request)
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
            $this->legislationSubjectCreateService->create($fileData);
            
            DB::commit();
            
            return redirect('/legislacao_assuntos')->with('flash', [
                'type' => 'success',
                'message' => 'Assunto criado com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao cadastrar!'
            ]);
        }
    }

    public function show($subject_id)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $legislation_subjects = LegislationSubject::with('legislations')->latest()->get();
            $subject_selected = $this->legislationSubjectService->show($subject_id);
            
            return Inertia::render('LegislationSubject/Show', compact('subject_selected', 'legislation_subjects', 'unit'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao buscar o assunto!'
            ]);
        }
    }

    public function update(LegislationSubjectRequest $request, $subject_id)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->legislationSubjectUpdateService->update($request->toArray(), $subject_id);
            
            DB::commit();
            
            return redirect('/legislacao_assuntos/' . $subject_id)->with('flash', [
                'type' => 'success',
                'message' => 'Assunto editado com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao editar!'
            ]);
        }
    }

    public function destroy($legislation_subject)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $subject = LegislationSubject::find($legislation_subject);
            $subject->delete();
            
            return redirect('/legislacao_assuntos')->with('flash', [
                'type' => 'success',
                'message' => 'Assunto deletado com sucesso!'
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao deletar o assunto!'
            ]);
        }
    }
}
