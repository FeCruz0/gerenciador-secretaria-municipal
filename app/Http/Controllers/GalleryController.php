<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Http\Requests\GalleryRequest;
use App\Models\Banner;
use App\Models\GalleryCategory;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Project;
use App\Models\Unit;
use App\Services\GalleryService;
use App\Services\GalleryCreateService;
use App\Services\GalleryUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class GalleryController extends Controller
{
    public function __construct(
        protected GalleryService $galleryService,
        protected GalleryCreateService $galleryCreateService,
        protected GalleryUpdateService $galleryUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Galeria')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $galleries = Gallery::all();
            return Inertia::render('Gallery/Index', compact('galleries', 'unit'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao procurar as Imagens da Galeria Cadastradas!',
            ]);
        }
    }

    public function store(
        GalleryRequest $request
    ){
        if (! Gate::allows('Criar Galeria')) {
            abort(403);
        }

        try {
            DB::beginTransaction();
                 
            $request->validate([
                'title' => 'required',
                'image_small' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'image_large' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
            ]);
        
            $path_image_small = Storage::disk('gallery')->put('small', $request->file( key:'image_small'));
            $path_image_large = Storage::disk('gallery')->put('large', $request->file( key:'image_large'));

            $galleryData = array_merge(
                $request->toArray(),
                [
                    'image_small'  => $path_image_small,
                    'image_large'  => $path_image_large
                ]
            );

            $this->galleryCreateService->create($galleryData);
            
            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Galeria criada com sucesso!',
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro Cadastrar!',
            ]);
        }
    }

    public function show($gallery_id)
    {
        if (! Gate::allows('Ver e Listar Galeria')) {
            abort(403);
        }

        try {
            $gallery = $this->galleryService->show($gallery_id);

            $unit = Unit::where('web', true)->first();
            return Inertia::render('Gallery/Show', compact('gallery', 'unit'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar a imagem!',
            ]);
        }
    }

    public function update(
        GalleryRequest $request, $gallery_id
    ){
        if (! Gate::allows('Editar Galeria')) {
            abort(403);
        }

        try {
            DB::beginTransaction();
            
            if(isset($request['image_small']) && isset($request['image_large'])){
                $request->validate([
                    'title' => 'required',
                    'image_small' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'image_large' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                ]);
            
                $path_image_small = Storage::disk('gallery')->put('small', $request->file( key:'image_small'));
                $path_image_large = Storage::disk('gallery')->put('large', $request->file( key:'image_large'));
    
                $galleryData = array_merge(
                    $request->toArray(),
                    [
                        'image_small'  => $path_image_small,
                        'image_large'  => $path_image_large
                    ]
                );

                $this->galleryUpdateService->update($galleryData, $gallery_id);
            }
            else{
                if(isset($request['image_small'])){
                    $request->validate([
                        'title' => 'required',
                        'image_small' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                    ]);
                
                    $path_image_small = Storage::disk('gallery')->put('small', $request->file( key:'image_small'));
        
                    $galleryData = array_merge(
                        $request->toArray(),
                        [
                            'image_small'  => $path_image_small
                        ]
                    );

                    $this->galleryUpdateService->update($galleryData, $gallery_id);

                }
                elseif(isset($request['image_large'])){
                    $request->validate([
                        'title' => 'required',
                        'image_large' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                    ]);
                
                    $path_image_large = Storage::disk('gallery')->put('large', $request->file( key:'image_large'));
        
                    $galleryData = array_merge(
                        $request->toArray(),
                        [
                            'image_large'  => $path_image_large
                        ]
                    );

                    $this->galleryUpdateService->update($galleryData, $gallery_id);

                }else{

                    $this->galleryUpdateService->update($request->toArray(), $gallery_id);

                }
            }
            
            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Galeria editada com sucesso!',
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar!',
            ]);
        }
    }

    public function destroy($gallery_id)
    {
        if (! Gate::allows('Deletar Galeria')) {
            abort(403);
        }

        try {
            $for_delete = Gallery::find($gallery_id);
            $for_delete->delete();
            return redirect('/galeria_imagens')->with('flash', [
                'type'    => 'success',
                'message' => 'Galeria deletada com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar a Galeria!',
            ]);
        }
    }
    //web
    

    public function gallery_web_index()
    {
        $banner = Banner::where('banner_type_id', 13)->first();
        $galleries = Gallery::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(12);
        $unit = Unit::where('web', true)->first();
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        return view('web.gallery.index', compact('banner', 'galleries','unit', 'news', 'projects', 'leaderships'));
    }
}
