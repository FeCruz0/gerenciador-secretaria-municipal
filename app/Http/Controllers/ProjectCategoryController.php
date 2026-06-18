<?php

namespace App\Http\Controllers;


use App\Models\ProjectCategory;
use App\Http\Requests\ProjectCategoryRequest;
use App\Models\Unit;
use App\Services\ProjectCategoryService;
use App\Services\ProjectCategoryCreateService;
use App\Services\ProjectCategoryUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ProjectCategoryController extends Controller
{


    public function __construct(
        protected ProjectCategoryService $projectCategoryService,
        protected ProjectCategoryCreateService $projectCategoryCreateService,
        protected ProjectCategoryUpdateService $projectCategoryUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Projetos')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $categories = ProjectCategory::with('projects')->latest()->get();
            return Inertia::render('Project/CategoryIndex', [
                'categories' => $categories,
                'unit' => $unit
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Categorias Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function store(
        ProjectCategoryRequest $request
    ){
        if (! Gate::allows('Criar Projetos')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $fileData = array_merge(
                $request->toArray(),
                [
                    'active'  => 1
                ]
            );
            $this->projectCategoryCreateService->create($fileData);

            flash('Categoria criada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($category_id)
    {
        if (! Gate::allows('Ver e Listar Projetos')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $categories = ProjectCategory::with('projects')->latest()->get();
            $category_selected = $this->projectCategoryService->show($category_id);
            $unit = Unit::where('web', true)->first();
            return Inertia::render('Project/CategoryShow', [
                'category_selected' => $category_selected,
                'categories' => $categories,
                'unit' => $unit
            ]);
        } catch (\Exception $exception) {
            flash('Erro ao buscar a Categoria!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        ProjectCategoryRequest $request, $category_id
    ){
        if (! Gate::allows('Editar Projetos')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $this->projectCategoryUpdateService->update($request->toArray(), $category_id);

            flash('Categoria editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($projectcategory)
    {
        if (! Gate::allows('Deletar Projetos')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $for_delete = ProjectCategory::find($projectcategory);
            $for_delete->delete();
            flash('Categoria deletada com sucesso!')->success();
            return redirect('/projeto_categorias');
        } catch (\Exception $exception) {
            flash('Erro ao deletar a Categoria!')->error();
            return redirect()->back()->withInput();
        }
    }
}
