<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnitConservationController extends Controller
{
    public function __construct(
        protected ProjectService $projectService,
        protected ProjectCreateService $projectCreateService,
        protected ProjectUpdateService $projectUpdateService,
    ){}

    public function index(): View
    {
        
        if (! Gate::allows('Ver e Listar Projetos')) {
            return view('pages.not-authorized');
        }

        try{
            $pageConfigs = ['pageHeader' => false];
            $unit = Unit::where('web', true)->first();

            $projects = Project::with('category')
                                        ->latest()
                                        ->get();
            return view('admin.project.index', ['pageConfigs' => $pageConfigs], compact('projects', 'unit'));
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Projetos Cadastrados!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create(): View
    {
        if (! Gate::allows('Criar Projetos')) {
            return view('pages.not-authorized');
        }

        $pageConfigs = ['pageHeader' => false];
        $unit = Unit::where('web', true)->first();

        $categories = ProjectCategory::with('projects')->orderBy('title', 'asc')->get();

        return view('admin.conservationUnit', ['pageConfigs' => $pageConfigs], compact('categories', 'unit'));

    }

    public function store(
        ProjectRequest $request
    ){
        
        if (! Gate::allows('Criar Projetos')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();

            $currentuuid = Auth::user()->id;

            if(isset($request['thumb'])){
                 
                $request->validate([
                    'title' => 'required',
                    'thumb' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                ]);
            
                $path = Storage::disk('projects')->put('thumbs', $request->file( key:'thumb'));

                $projectData = array_merge(
                    $request->toArray(),
                    [
                        'user_id'  => $currentuuid,
                        'path'  => $path
                    ]
                );
            }
            else{

                $request->validate([
                    'title' => 'required' 
                ]);
            
                $projectData = array_merge(
                    $request->toArray(),
                    [
                        'user_id'  => $currentuuid
                    ]
                );

            }

            $this->projectCreateService->create($projectData);
            
            flash('Projeto criado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            dd($throwable);
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($project_id)
    {
        
        if (! Gate::allows('Ver e Listar Projetos')) {
            return view('pages.not-authorized');
        }

        try{
            // $project = $this->projectService->show($project_id);
        
            $project = Project::find($project_id);
            
            $project_files = $project->files;


            $unit = Unit::where('web', true)->first();

            $categories = ProjectCategory::with('projects')->orderBy('title', 'asc')->get();

            return view('admin.project.show', compact('project', 'project_files', 'categories', 'unit' ));
        } catch (\Exception $exception) {
            flash('Erro ao buscar a Projeto!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        ProjectRequest $request, $project_id
    ){
        if (! Gate::allows('Editar Projetos')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();

            $currentuuid = Auth::user()->id;

            if(isset($request['thumb'])){
                
                $request->validate([
                    'title' => 'required',
                    'thumb' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                ]);
            
                //$path = $request->file( key:'image')->store( path: 'images/Project');
                $path = Storage::disk('projects')->put('thumbs', $request->file( key:'thumb'));

                $projectData = array_merge(
                    $request->toArray(),
                    [
                        'user_id'  => $currentuuid,
                        'path'  => $path
                    ]
                );
            }
            else{

                $request->validate([
                    'title' => 'required' 
                ]);
            
                $projectData = array_merge(
                    $request->toArray(),
                    [
                        'user_id'  => $currentuuid
                    ]
                );

            }
            $this->projectUpdateService->update($projectData, $project_id);
            
            flash('Projeto editado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($project_id)
    {
        
        if (! Gate::allows('Deletar Projetos')) {
            return view('pages.not-authorized');
        }

        try{
            $for_delete = Project::find($project_id);
            $for_delete->delete();
            flash('Projeto deletado com sucesso!')->success();
            return redirect('/projetos');
        } catch (\Exception $exception) {
            flash('Erro ao deletar a Projeto!')->error();
            return redirect()->back()->withInput();
        }
    }
    //web
    

    public function projects_web_index()
    {
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->get();
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 3)->first();
        $categories = ProjectCategory::all();
        return view('web.project.index', compact('banner', 'projects', 'categories', 'unit'));
    }

    public function projects_web_index_filter_title(Request $request)
    {
        $projects = Project::filter($request->all())->where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 3)->first();
        $categories = ProjectCategory::all();
        return view('web.project.index', compact('banner', 'projects', 'categories', 'unit'));
    }

    public function projects_web_index_filter_category($category_id)
    {
        $projects = Project::where('status', 'PUBLISHED')->where('category_id', $category_id)->orderBy('id', 'desc')->paginate(3);
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 3)->first();
        $categories = ProjectCategory::all();
        return view('web.project.index', compact('banner', 'projects', 'categories', 'unit'));
    }

    public function projects_web_index_filter_tag($tag_id)
    {
        $projects = Project::with('tags')->where('status', 'PUBLISHED')->where('tags->id', $tag_id)->orderBy('id', 'desc')->paginate(3);
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 3)->first();
        $categories = ProjectCategory::all();
        return view('web.project.index', compact('banner', 'projects', 'categories', 'unit'));
    }

    public function project_web_show($project_id)
    {
        $project = Project::find($project_id);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->get();
        $unit = Unit::where('web', true)->first();
        $categories = ProjectCategory::all();
        return view('web.project.show', compact('projects', 'project', 'unit', 'categories'));
    }
}
