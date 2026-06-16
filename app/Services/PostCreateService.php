<?php

namespace App\Services;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Media;
use App\Models\Post;

class PostCreateService
{
    public function __construct(
        protected PostService $PostService,
    ) {
        //
    }

    public function create(array $request)
    {
        try {
            DB::beginTransaction();

            $post = Post::create([
                'type_post_id' => $request['type_post_id'],
                'user_id' => $request['user_id'],
                'title' => $request['title'],
                'sub_title' => $request['sub_title'],
                'order' => $request['order'],
                'link' => $request['link'],
                'content' => $request['content'],
                'active' => $request['active']
            ]);

            Media::create([
                'post_id' => $post->id,
                'type_media_id' => '1',
                'url' => $request['path_web']
            ]);

            DB::commit();
        } catch (Exception $exception) {
            //Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
