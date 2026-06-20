<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Http\Requests\AboutRequest;
use App\Models\Banner;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Project;
use App\Models\Unit;
use App\Services\AboutService;
use App\Services\AboutCreateService;
use App\Services\AboutUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Throwable;
use App\Enums\Permission;

class AboutController extends Controller
{
    public function __construct(
        protected AboutService $aboutService,
        protected AboutCreateService $aboutCreateService,
        protected AboutUpdateService $aboutUpdateService,
    ){}

    public function create(): View
    {
        
        if (! Gate::allows(Permission::VIEW_ABOUT->value)) {
            abort(403);
        }

        try{
            $pageConfigs = ['pageHeader' => false];
            $unit = Unit::where('web', true)->first();

            $units = Unit::all();
            return view('admin.about.create', ['pageConfigs' => $pageConfigs], compact('units', 'unit'));
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Unidades Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function store(
        AboutRequest $request
    ){
        
        if (! Gate::allows(Permission::EDIT_ABOUT->value)) {
            abort(403);
        }

        try {
            DB::beginTransaction();
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
        
            $path_image = Storage::disk('about')->put('image', $request->file( key:'image'));

            $galleryData = array_merge(
                $request->toArray(),
                [
                    'image'  => $path_image,
                    'body'  => $request['content']
                ]
            );

            $this->aboutCreateService->create($galleryData);
            
            flash('Criada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($about_id)
    {
        
        if (! Gate::allows(Permission::VIEW_ABOUT->value)) {
            abort(403);
        }

        try{
            $about = $this->aboutService->show($about_id);
            $units = Unit::all();
            $unit = Unit::where('web', true)->first();

            return view('admin.about.show', compact('about', 'units', 'unit'));
        } catch (\Exception $exception) {
            flash('Erro ao buscar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        AboutRequest $request, $about_id
    ){
        
        if (! Gate::allows(Permission::EDIT_ABOUT->value)) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            if(isset($request['image'])){
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);
            
                $path_image = Storage::disk('about')->put('image', $request->file( key:'image'));

                $aboutData = array_merge(
                    $request->toArray(),
                    [
                        'image'  => $path_image,
                        'body'  => $request['content']
                    ]
                );
            }
            else{

                $aboutData = array_merge(
                    $request->toArray(),
                    [
                        'body'  => $request['content']
                    ]
                );

            }

            $this->aboutUpdateService->update($aboutData, $about_id);
            
            flash('Editado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            dd($throwable);
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($about_id)
    {
        
        if (! Gate::allows(Permission::DELETE_ABOUT->value)) {
            abort(403);
        }

        try{
            $for_delete = About::find($about_id);
            $for_delete->delete();
            flash('Deletada com sucesso!')->success();
            return redirect('/sobres');
        } catch (\Exception $exception) {
            flash('Erro ao deletar!')->error();
            return redirect()->back()->withInput();
        }
    }


    //web
    

    public function about_web_index ()
    {
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 12)->first();
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.about.index', compact('banner', 'unit', 'news', 'projects', 'leaderships', 'galleries'));
    }
}
