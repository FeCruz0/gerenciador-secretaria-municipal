<?php

namespace App\Http\Controllers;

use App\Models\LegislationCategory;
use App\Http\Requests\LegislationCategoryRequest;
use App\Models\Unit;
use App\Services\LegislationCategoryService;
use App\Services\LegislationCategoryCreateService;
use App\Services\LegislationCategoryUpdateService;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LegislationCategoryController extends Controller
{
    public function __construct(
        protected LegislationCategoryService $legislationCategoryService,
        protected LegislationCategoryCreateService $legislationCategoryCreateService,
        protected LegislationCategoryUpdateService $legislationCategoryUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $legislation_categories = LegislationCategory::with('legislations')->latest()->get();
            
            return Inertia::render('LegislationCategory/Index', compact('unit', 'legislation_categories'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao procurar as Categorias Cadastradas!'
            ]);
        }
    }

    public function store(LegislationCategoryRequest $request)
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
            $this->legislationCategoryCreateService->create($fileData);
            
            DB::commit();
            
            return redirect('/legislacao_categorias')->with('flash', [
                'type' => 'success',
                'message' => 'Categoria criada com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao cadastrar!'
            ]);
        }
    }

    public function show($category_id)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $legislation_categories = LegislationCategory::with('legislations')->latest()->get();
            $category_selected = $this->legislationCategoryService->show($category_id);
            
            return Inertia::render('LegislationCategory/Show', compact('category_selected', 'legislation_categories', 'unit'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao buscar a categoria!'
            ]);
        }
    }

    public function update(LegislationCategoryRequest $request, $category_id)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }
        
        try {
            DB::beginTransaction();
            $this->legislationCategoryUpdateService->update($request->toArray(), $category_id);
            
            DB::commit();
            
            return redirect('/legislacao_categorias/' . $category_id)->with('flash', [
                'type' => 'success',
                'message' => 'Categoria editada com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao editar!'
            ]);
        }
    }

    public function destroy($legislation_category)
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403);
        }

        try {
            $category = LegislationCategory::find($legislation_category);
            $category->delete();
            
            return redirect('/legislacao_categorias')->with('flash', [
                'type' => 'success',
                'message' => 'Categoria deletada com sucesso!'
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao deletar a categoria!'
            ]);
        }
    }
}
