<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use App\Models\Unit;
use App\Services\PostService;
use App\Services\PostCreateService;
use App\Services\PostUpdateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PostController extends Controller
{
    
    public function __construct(
        protected PostService $postService,
        protected PostCreateService $postCreateService,
        protected PostUpdateService $postUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Capas do Site')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $posts = Post::with('user', 'type_post', 'media')->latest()->get();
            return Inertia::render('Post/Index', compact('posts', 'unit'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao procurar as Capas Cadastradas!',
            ]);
        }
    }

    public function store(
        PostRequest $request
    ){
        if (! Gate::allows('Editar Capas do Site')) {
            abort(403);
        }
        try {
            DB::beginTransaction();
            $currentuuid = Auth::user()->id;
            $request->validate([
                'image_web' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            ]);

            $path_web = Storage::disk('posts')->put('web', $request->file('image_web'));

            $postData = array_merge(
                $request->toArray(),
                [
                    'type_post_id'  => 1,
                    'user_id'       => $currentuuid,
                    'path_web'      => $path_web,
                ]
            );

            $this->postCreateService->create($postData);
            
            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Capa do Site criada com sucesso!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao Cadastrar!',
            ]);
        }
    }

    public function show($post_id)
    {
        if (! Gate::allows('Ver e Listar Capas do Site')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $posts = Post::with('user', 'type_post', 'media')->latest()->get();
            $post_selected = $this->postService->show($post_id);
            $media_web = $post_selected->media->where('type_media_id', 1)->first();
            $media_phone = $post_selected->media->where('type_media_id', 2)->first();
            return Inertia::render('Post/Show', compact('post_selected', 'posts', 'media_web', 'media_phone', 'unit'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar a Capa!',
            ]);
        }
    }

    public function update(
        PostRequest $request, $post_id
    ){
        if (! Gate::allows('Editar Capas do Site')) {
            abort(403);
        }
        try {
            DB::beginTransaction();

            $currentuuid = Auth::user()->id;

            if (isset($request['image']) || isset($request['image_mobile'])) {
                if (isset($request['image']) && isset($request['image_mobile'])) {

                    $request->validate([
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                        'image_mobile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                    ]);
                
                    $path_phone = Storage::disk('posts')->put('phone', $request->file('image_mobile'));
                    $path_web = Storage::disk('posts')->put('web', $request->file('image'));

                    $postData = array_merge(
                        $request->toArray(),
                        [
                            'type_post_id'  => 1,
                            'user_id'       => $currentuuid,
                            'path_web'      => $path_web,
                            'path_phone'    => $path_phone
                        ]
                    );
                } else {
                    if (isset($request['image'])) {

                        $request->validate([
                            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                        ]);
                    
                        $path_web = Storage::disk('posts')->put('web', $request->file('image'));

                        $postData = array_merge(
                            $request->toArray(),
                            [
                                'type_post_id'  => 1,
                                'user_id'       => $currentuuid,
                                'path_web'      => $path_web
                            ]
                        );

                    }
                    if (isset($request['image_mobile'])) {

                        $request->validate([
                            'image_mobile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                        ]);
                    
                        $path_phone = Storage::disk('posts')->put('phone', $request->file('image_mobile'));
                        
                        $postData = array_merge(
                            $request->toArray(),
                            [
                                'type_post_id'  => 1,
                                'user_id'       => $currentuuid,
                                'path_phone'    => $path_phone
                            ]
                        );
                        
                    }
                }
            } else {
            
                $postData = array_merge(
                    $request->toArray(),
                    [
                        'type_post_id'  => 1,
                        'user_id'       => $currentuuid
                    ]
                );
            }

            $this->postUpdateService->update($postData, $post_id);
            
            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Capa do Site editada com sucesso!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar!',
            ]);
        }
    }

    public function destroy($post)
    {
        if (! Gate::allows('Deletar Capas do Site')) {
            abort(403);
        }

        try {
            $for_delete = Post::find($post);
            $for_delete->delete();
            return redirect('/capas')->with('flash', [
                'type'    => 'success',
                'message' => 'Capa do Site deletada com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar a Capa!',
            ]);
        }
    }
}

