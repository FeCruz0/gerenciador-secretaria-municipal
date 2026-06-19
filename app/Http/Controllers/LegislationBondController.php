<?php

namespace App\Http\Controllers;

use App\Models\Legislation;
use App\Http\Requests\LegislationBondRequest;
use App\Models\LegislationBond;
use App\Models\Unit;
use App\Services\LegislationBondCreateService;
use App\Services\LegislationBondUpdateService;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LegislationBondController extends Controller
{
    public function __construct(
        protected LegislationBondCreateService $legislationBondCreateService,
        protected LegislationBondUpdateService $legislationBondUpdateService,
    ){}

    public function store(LegislationBondRequest $request)
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
            $this->legislationBondCreateService->create($fileData);
            
            DB::commit();
            return redirect()->back()->with('flash', [
                'type' => 'success',
                'message' => 'Vínculo criado com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao cadastrar!'
            ]);
        }
    }

    public function show($bond_id)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $bond = LegislationBond::find($bond_id);
            $legislations = Legislation::with('category', 'situation', 'subjects')
                                        ->latest()
                                        ->get();
            return Inertia::render('LegislationBond/Show', compact('bond', 'legislations', 'unit'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao buscar o Vínculo!'
            ]);
        }
    }

    public function update(LegislationBondRequest $request, $bond_id)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }
        try {
            DB::beginTransaction();
            $this->legislationBondUpdateService->update($request->toArray(), $bond_id);
            
            DB::commit();
            return redirect()->back()->with('flash', [
                'type' => 'success',
                'message' => 'Vínculo editado com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao editar!'
            ]);
        }
    }

    public function destroy($bond_id)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $bond = LegislationBond::find($bond_id);
            $bond->delete();
            return redirect('/legislacoes')->with('flash', [
                'type' => 'success',
                'message' => 'Vínculo deletado com sucesso!'
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao deletar o Vínculo!'
            ]);
        }
    }
}
