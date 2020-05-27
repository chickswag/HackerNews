<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Posts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PostsControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::latest()->get();
        return response()->json(['posts'=> $posts, 200]);
    }

    public function fetchPosts(){
        $posts = Posts::count();
        $total = 30; //for now

        if($posts < $total){
            $bestStoriesArray   = self::getBestStories();
            $topStoriesArray    = self::getTopStories();
            $newStoriesArray    = self::getNewStories();

            $arrAllStories = array_merge($bestStoriesArray,$topStoriesArray,$newStoriesArray);

            foreach ($arrAllStories as $story){
                $postExist= Posts::where(['post_id' => $story['id']])->count();
                if($postExist == 0){
                    $post = new Posts();
                    $post->created_by   = $story['by'];
                    $post->post_id      = $story['id'];
                    $post->title        = $story['title'];
                    $post->created_at   = Carbon::createFromTimestamp($story['time']);
                    $post->comment_ids  = isset($story['kids']) ? json_encode($story['kids']):null;
                    $post->comment_count= $story['descendants'];
                    $post->score        = $story['score'];
                    $post->type         = $story['story_type'];
                    $post->save();
                }
            }
            //save comments for each posts
            self::saveCommentsForStories();

        }

    }

    /**
     * get best stories
     * @return array
     */
    public static function getBestStories(){
        $allBestStories     = [];
        $bestStories        = Http::get('https://hacker-news.firebaseio.com/v0/beststories.json?orderBy=%22$key%22&limitToFirst=10');

        if($bestStories->ok()){
            $arrBestStories     = $bestStories->json();
            foreach($arrBestStories as $storyId){
                $storyPost  = Http::get('https://hacker-news.firebaseio.com/v0/item/'.$storyId.'.json');
                $storyData  = $storyPost->json();
                $storyData['story_type'] = "best";
                array_push($allBestStories,$storyData);
            }
        }
        return $allBestStories;
    }

    /**
     * get new stories
     * @return array
     */
    public static function getNewStories(){
        $allNewStories      = [];
        $newStories         = Http::get('https://hacker-news.firebaseio.com/v0/newstories.json?orderBy=%22$key%22&limitToFirst=10');

        if($newStories->ok()){
            $arrNewStories      = $newStories->json();
            foreach($arrNewStories as $storyId){
                $storyPost  = Http::get('https://hacker-news.firebaseio.com/v0/item/'.$storyId.'.json');
                $storyData  = $storyPost->json();
                $storyData['story_type'] = "new";
                array_push($allNewStories,$storyData);
            }
        }
        return $allNewStories;

    }

    /**
     * get top stories
     * @return array
     */
    public static function getTopStories(){
        $allTopStories      = [];
        $topStories         = Http::get('https://hacker-news.firebaseio.com/v0/topstories.json?orderBy=%22$key%22&limitToFirst=10');

        if($topStories->ok()){
            $arrTopStories     = $topStories->json();
            foreach($arrTopStories as $storyId){
                $storyPost  = Http::get('https://hacker-news.firebaseio.com/v0/item/'.$storyId.'.json');
                $storyData  = $storyPost->json();
                $storyData['story_type'] = "top";
                array_push($allTopStories,$storyData);
            }
        }
        return $allTopStories;
    }

    /**
     * insert comments for post
     * @return |null
     */
    public static function saveCommentsForStories(){

        $commentIds  = Posts::whereNotNull('comment_ids')->get();
        if($commentIds){

            foreach ($commentIds as $arrIds){
                $carrCommentIds = json_decode($arrIds['comment_ids']);
                foreach ($carrCommentIds as $commentId) {
                    $comments = Http::get('https://hacker-news.firebaseio.com/v0/item/' . $commentId . '.json');

                    if ($comments->ok()) {
                        $commentData = $comments->json();
                        $story_comment = new Comments();
                        $story_comment->posts_id = $arrIds->id;
                        $story_comment->comment = $commentData['text'];
                        $story_comment->type = $commentData['type'];
                        $story_comment->created_at = Carbon::createFromTimestamp($commentData['time']);
                        $story_comment->save();
                    }
                }

            }
        }
        return null;

    }
}
