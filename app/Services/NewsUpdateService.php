<?php

namespace App\Services;

use App\Models\News;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\NewsTag;
use Illuminate\Support\Facades\Storage;

class NewsUpdateService
{
    public function __construct(
        protected UserService $userService,
        protected BiddingService $biddingService,
        protected NewsService $newsService,
    ) {
        //
    }

    public function update(array $request, $news_id)
    {
        try {
            DB::beginTransaction();

            $news = News::find($news_id);
            $old_path = $news->image;

            $news->user_id = $request['user_id'];
            $news->category_id = $request['category_id'];
            $news->title = $request['title'];
            $news->excerpt = $request['content'];
            $news->body = $request['content'];
            $news->image = isset($request['path']) ? $request['path']  : $old_path;
            $news->meta_description = $request['content'];
            $news->meta_keywords = $request['meta_keywords'];
            $news->status = $request['status'];
            $news->save();


            $old_tags = NewsTag::where('news_id', $news_id)->get();

            foreach($old_tags as $tagdelete){
                $tagdelete->forceDelete();
            }

            foreach ($request['tags'] as  $tag) {
                $tag_id = $tag;

                NewsTag::create([
                    'news_id' => $news->id,
                    'tag_id' => $tag_id,
                ]);
            }

            if(isset($request['path'])){
                Storage::disk('news')->delete($old_path);
            }

            DB::commit();
        } catch (Exception $exception) {
            //Bugsnag::notifyException($exception);
            DB::rollBack();
            throw new Exception($exception);
        }
    }
}
