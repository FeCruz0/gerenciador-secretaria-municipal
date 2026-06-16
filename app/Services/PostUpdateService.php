<?php

namespace App\Services;

use App\Models\Media;
use App\Models\Post;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostUpdateService
{
    public function __construct(
        protected PostService $postService,
    ) {
        //
    }
    
    public function update(array $request, $post_id)
    {
        try {
            DB::beginTransaction();
            
            $post = Post::find($post_id);
            $medias = $post->media;
            foreach($medias as $media){
                if($media->type_media_id == 1 && isset( $request['path_web'])){

                    Storage::disk('posts')->delete($media->url);

                    $mediaLocal = Media::find($media->id);
                    $mediaLocal->url = $request['path_web'];
                    $mediaLocal->save();
                }
                if($media->type_media_id == 2 && isset( $request['path_phone'])){

                    Storage::disk('posts')->delete($media->url);
                    
                    $mediaLocal = Media::find($media->id);
                    $mediaLocal->url = $request['path_phone'];
                    $mediaLocal->save();
                }
            }
            $post->user_id = $request['user_id'];
            if(isset($request['title'])){
                $post->title = $request['title'];
            }
            else{
                $post->title = '';
            }
            if(isset($request['sub_title'])){
                $post->sub_title = $request['sub_title'];
            }
            else{
                $post->sub_title = '';
            }
            $post->order = $request['order'];
            if(isset($request['title'])){
                $post->link = $request['link'];
            }
            else{
                $post->link = '';
            }
            $post->active = $request['active'];
            $post->save();



            DB::commit();
        } catch (Exception $exception) {
            //Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
