<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartamentRequest;
use App\Models\Departament;
use App\Models\Occupation;
use App\Models\Unit;
use App\Services\DepartamentService;
use App\Services\DepartamentCreateService;
use App\Services\DepartamentUpdateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class DepartamentController extends Controller
{
    public function __construct(
        protected DepartamentService $departamentService,
        protected DepartamentCreateService $departamentCreateService,
        protected DepartamentUpdateService $departamentUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Departamentos')) {
            abort(403);
        }

        $departaments = Departament::with('unit')->latest()->get();
        $units = Unit::all();

        return Inertia::render('Department/Index', [
            'departaments' => $departaments,
            'units'        => $units,
        ]);
    }

    public function store(
        DepartamentRequest $request
    ){
        if (! Gate::allows('Criar Departamentos')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->departamentCreateService->create($request->toArray());

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Departamento criado com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao adicionar o departamento!',
            ]);
        }
    }

    public function show($departament_id)
    {
        if (! Gate::allows('Editar Departamentos')) {
            abort(403);
        }

        try{
            $departaments = Departament::with('unit')->latest()->get();
            $units = Unit::all();
            $departament_selected = Departament::findOrFail($departament_id);

            return Inertia::render('Department/Index', [
                'departaments'         => $departaments,
                'units'                => $units,
                'departament_selected' => $departament_selected,
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar o departamento!',
            ]);
        }
    }

    public function update(
        DepartamentRequest $request, $departament_id
    ){
        if (! Gate::allows('Editar Departamentos')) {
            abort(403);
        }

        try {
            DB::beginTransaction();
            $this->departamentUpdateService->update($request->toArray(), $departament_id);

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Departamento editado com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar o departamento!',
            ]);
        }
    }

    public function destroy($departament)
    {
        if (! Gate::allows('Deletar Departamentos')) {
            abort(403);
        }

        try{
            $departamentModel = Departament::findOrFail($departament);
            $departamentModel->delete();

            return redirect()->route('departamentos.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Departamento deletado com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar o departamento!',
            ]);
        }
    }
    
    public function getDepartamentos(int $idUnit): JsonResponse
    {
        $departaments = Departament::where('unit_id', $idUnit)->orderBy('departament')->get();
        return Response::json($departaments);
    }
    
    public function getOccupations(int $idDepartament): JsonResponse
    {
        $occupations = Occupation::where('departament_id', $idDepartament)->orderBy('title')->get();
        return Response::json($occupations);
    }
}
