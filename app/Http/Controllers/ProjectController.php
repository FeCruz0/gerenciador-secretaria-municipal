<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\ProjectRequest;
use App\Models\Banner;
use App\Models\ProjectCategory;
use App\Models\Unit;
use App\Services\ProjectService;
use App\Services\ProjectCreateService;
use App\Services\ProjectUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Throwable;
use Inertia\Inertia;

class ProjectController extends Controller
{

    public function __construct(
        protected ProjectService $projectService,
        protected ProjectCreateService $projectCreateService,
        protected ProjectUpdateService $projectUpdateService,
    ){}

    public function index()
    {

        if (! Gate::allows('Ver e Listar Projetos')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $projects = Project::with('category')
                                        ->latest()
                                        ->get();
            return Inertia::render('Project/Index', [
                'projects' => $projects,
                'unit' => $unit
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Projetos Cadastrados!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create()
    {
        if (! Gate::allows('Criar Projetos')) {
            abort(403, 'This action is unauthorized.');
        }

        $unit = Unit::where('web', true)->first();

        $categories = ProjectCategory::with('projects')->orderBy('title', 'asc')->get();

        return Inertia::render('Project/Create', [
            'categories' => $categories,
            'unit' => $unit
        ]);

    }

    public function store(
        ProjectRequest $request
    ){

        if (! Gate::allows('Criar Projetos')) {
            abort(403, 'This action is unauthorized.');
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

            $detail = $request->content;

            if ($detail) {
                $dom = new \domdocument();
                $searchPage = mb_convert_encoding($detail, 'HTML-ENTITIES', "UTF-8");
                $dom->loadHtml($searchPage);
                $images = $dom->getelementsbytagname('img');

                foreach($images as $k => $img){
                    $data = $img->getattribute('src');

                    if (str_contains($data, ';') && str_contains($data, ',')) {
                        list($type, $data) = explode(';', $data);
                        list($type, $data)      = explode(',', $data);

                        $data = base64_decode($data);
                        $image_name= time().$k.'.png';
                        $path_img = 'content/'. $image_name;
                        Storage::disk('projects')->put('content/'. $image_name, $data);

                        $img->removeattribute('src');
                        $src_path = env('APP_URL') . '/storage/images/projects/'. $path_img;
                        $img->setattribute('class', 'img-content');
                        $img->setattribute('src', $src_path);
                    }
                }

                $detail = $dom->savehtml();
            }

            $projectData['content'] = $detail;

            $this->projectCreateService->create($projectData);

            flash('Projeto criado com sucesso!')->success();
            DB::commit();
            return redirect()->route('projetos.index');
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($project_id)
    {

        if (! Gate::allows('Ver e Listar Projetos')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $project = Project::with('files')->find($project_id);

            $project_files = $project->files;

            $unit = Unit::where('web', true)->first();

            $categories = ProjectCategory::with('projects')->orderBy('title', 'asc')->get();

            return Inertia::render('Project/Show', [
                'project' => $project,
                'project_files' => $project_files,
                'categories' => $categories,
                'unit' => $unit
            ]);
        } catch (\Exception $exception) {
            flash('Erro ao buscar a Projeto!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        ProjectRequest $request, $project_id
    ){
        if (! Gate::allows('Editar Projetos')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();

            $project_old = Project::find($project_id);
            $old_path = array("https://semas.arraial.rj.gov.br/storage/images/projects/");
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

            //unlinking old images
            $detail_old = $project_old->body;
            if ($detail_old) {
                $dom_old = new \domdocument();
                $searchPageOld = mb_convert_encoding($detail_old, 'HTML-ENTITIES', "UTF-8");
                $dom_old->loadHtml($searchPageOld);
                $images_old = $dom_old->getelementsbytagname('img');
            } else {
                $images_old = [];
            }

            //saving new images
            $detail = $request->content;

            if ($detail) {
                $dom = new \domdocument();
                $searchPage = mb_convert_encoding($detail, 'HTML-ENTITIES', "UTF-8");
                $dom->loadHtml($searchPage);
                $images = $dom->getelementsbytagname('img');

                foreach($images_old as $k => $img_old){
                    $path_for_unlink = $img_old->getattribute('src');
                    $path_for_unlink = str_replace($old_path, "", $path_for_unlink);
                    $verification = true;
                    foreach($images as $k => $img){
                        $data = $img->getattribute('src');
                        $data = str_replace($old_path, "", $data);
                        if($path_for_unlink == $data){
                            $verification = false;
                            break;
                        }
                    }
                    if($verification){
                        Storage::disk('projects')->delete($path_for_unlink);
                    }
                }

                foreach($images as $k => $img){
                    $data = $img->getattribute('src');
                    $path_for_update = str_replace($old_path, "", $data);
                    if (!(Storage::disk('projects')->exists($path_for_update))) {
                        if (str_contains($data, ';') && str_contains($data, ',')) {
                            list($type, $data) = explode(';', $data);
                            list($type, $data)      = explode(',', $data);

                            $data = base64_decode($data);
                            $image_name= time().$k.'.png';
                            $path_img = 'content/'. $image_name;
                            Storage::disk('projects')->put('content/'. $image_name, $data);
                            $img->removeattribute('src');
                            $src_path = env('APP_URL') . '/storage/images/projects/'. $path_img;
                            $img->setattribute('src', $src_path);
                        }
                    }
                    $img->setattribute('class', 'img-content');
                }

                $detail = $dom->savehtml();
            }

            $projectData['content'] = $detail;

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
            abort(403, 'This action is unauthorized.');
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


    public function web_index()
    {
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->get();
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 3)->first();
        $categories = ProjectCategory::all();
        return view('web.project.index', compact('banner', 'projects', 'categories', 'unit'));
    }

    public function web_index_filter_title(Request $request)
    {
        $projects = Project::filter($request->all())->where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 3)->first();
        $categories = ProjectCategory::all();
        return view('web.project.index', compact('banner', 'projects', 'categories', 'unit'));
    }

    public function web_index_filter_category($category_id)
    {
        $projects = Project::where('status', 'PUBLISHED')->where('category_id', $category_id)->orderBy('id', 'desc')->paginate(3);
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 3)->first();
        $categories = ProjectCategory::all();
        return view('web.project.index', compact('banner', 'projects', 'categories', 'unit'));
    }

    public function web_index_filter_tag($tag_id)
    {
        $projects = Project::with('tags')->where('status', 'PUBLISHED')->where('tags->id', $tag_id)->orderBy('id', 'desc')->paginate(3);
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 3)->first();
        $categories = ProjectCategory::all();
        return view('web.project.index', compact('banner', 'projects', 'categories', 'unit'));
    }

    public function web_show($project_id)
    {
        $project = Project::find($project_id);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->get();
        $unit = Unit::where('web', true)->first();
        $categories = ProjectCategory::all();
        return view('web.project.show', compact('projects', 'project', 'unit', 'categories'));
    }
}
