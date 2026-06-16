<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use App\Models\Unit;
use App\Services\PostService;
use App\Services\PostCreateService;
use App\Services\PostUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    
    public function __construct(
        protected PostService $postService,
        protected PostCreateService $postCreateService,
        protected PostUpdateService $postUpdateService,
    ){}

    public function index(): View
    {
        if (! Gate::allows('Ver e Listar Capas do Site')) {
            return view('pages.not-authorized');
        }

        try{
            $pageConfigs = ['pageHeader' => false];

            $unit = Unit::where('web', true)->first();
            $posts = Post::with('user', 'type_post', 'media')->latest()->get();
            return view('admin.post.index', ['pageConfigs' => $pageConfigs], compact('posts', 'unit'));
        } catch (\Throwable $throwable) {
            dd($throwable);
            flash('Erro ao procurar as PostS Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function store(
        PostRequest $request
    ){
        if (! Gate::allows('Editar Capas do Site')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();
            $currentuuid = Auth::user()->id;
            $request->validate([
                'image_web' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            ]);

            $path_web = Storage::disk('posts')->put('web', $request->file( key:'image_web'));

            $postData = array_merge(
                $request->toArray(),
                [
                    'type_post_id'  => 1,
                    'user_id'  => $currentuuid,
                    'path_web'  => $path_web,
                ]
            );

            $this->postCreateService->create($postData);
            
            flash('Capa do Site criada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($post_id)
    {
        if (! Gate::allows('Ver e Listar Capas do Site')) {
            return view('pages.not-authorized');
        }

        try{
            
            $unit = Unit::where('web', true)->first();
            $posts = Post::with('user', 'type_post', 'media')->latest()->get();
            $post_selected = $this->postService->show($post_id);
            $media_web = $post_selected->media->where('type_media_id', 1)->first();
            $media_phone = $post_selected->media->where('type_media_id', 2)->first();
            return view('admin.post.show', compact('post_selected', 'posts', 'media_web', 'media_phone', 'unit'));
        } catch (\Exception $exception) {
            dd($exception);
            flash('Erro ao buscar a Capa!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        PostRequest $request, $post_id
    ){
        if (! Gate::allows('Editar Capas do Site')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();

            $currentuuid = Auth::user()->id;

            if(isset($request['image']) || isset($request['image_mobile'])){
                if(isset($request['image']) && isset($request['image_mobile'])){

                    $request->validate([
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                        'image_mobile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                    ]);
                
                    $path_phone = Storage::disk('posts')->put('phone', $request->file( key:'image_mobile'));
                    $path_web = Storage::disk('posts')->put('web', $request->file( key:'image'));

                    $postData = array_merge(
                        $request->toArray(),
                        [
                            'type_post_id'  => 1,
                            'user_id'  => $currentuuid,
                            'path_web'  => $path_web,
                            'path_phone'  => $path_phone
                        ]
                    );
                }
                else{
                    if(isset($request['image'])){

                        $request->validate([
                            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                        ]);
                    
                        $path_web = Storage::disk('posts')->put('web', $request->file( key:'image'));

                        $postData = array_merge(
                            $request->toArray(),
                            [
                                'type_post_id'  => 1,
                                'user_id'  => $currentuuid,
                                'path_web'  => $path_web
                            ]
                        );

                    }
                    if(isset($request['image_mobile'])){

                        $request->validate([
                            'image_mobile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                        ]);
                    
                        $path_phone = Storage::disk('posts')->put('phone', $request->file( key:'image_mobile'));
                        
                        $postData = array_merge(
                            $request->toArray(),
                            [
                                'type_post_id'  => 1,
                                'user_id'  => $currentuuid,
                                'path_phone'  => $path_phone
                            ]
                        );
                        
                    }
                }
            }
            else{
            
                $postData = array_merge(
                    $request->toArray(),
                    [
                        'type_post_id'  => 1,
                        'user_id'  => $currentuuid
                    ]
                );
            }

            $this->postUpdateService->update($postData, $post_id);
            
            flash('Capa do Site editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($post)
    {
        if (! Gate::allows('Deletar Capas do Site')) {
            return view('pages.not-authorized');
        }

        try{
            $for_delete = Post::find($post);
            $for_delete->delete();
            flash('Capa do Site deletada com sucesso!')->success();
            return redirect('/capas');
        } catch (\Exception $exception) {
            flash('Erro ao deletar a Post!')->error();
            return redirect()->back()->withInput();
        }
    }
}
