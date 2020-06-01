<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Jobs\CommentRepliesJob;
use App\Jobs\CreateCommentsJob;
use App\Jobs\GetPostsJob;
use App\Posts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class PostsController extends Controller
{

    public function __construct(){

//        $this->saveCommentBelongingToAComment();
//        $this->saveCommentsForStories();
//        $this->fetchPosts();
    }

    /**
     * @return array|string
     * @throws \Throwable
     */
    public function index()
    {
        $posts = Posts::latest()->paginate(30);
        return view('Posts.posts', compact('posts'))->render();
    }

    /**
     * @param $story_type
     * @return array|string
     * @throws \Throwable
     */
    public function filterByType($story_type)
    {
        $posts = Posts::where('type',$story_type)->paginate(30);
        switch ($story_type){
            case 'new':
                return view('Posts.new', compact('posts'))->render();
                break;
            case 'best':
                return view('Posts.best', compact('posts'))->render();
                break;
            case 'top':
                return view('Posts.top', compact('posts'))->render();
                break;
            default:
                return view('Posts.posts', compact('posts'))->render();
        }
    }

    /**
     *
     */
    public static function fetchPosts(){
        $posts      = Posts::get();
        $postCount  = $posts->count();
        $total      = 500;
        if($postCount <= $total){
            $newStoriesArray                        = self::getNewStories();
            $topStoriesArray                        = self::getTopStories();
            $bestStoriesArray                       = self::getBestStories();
            $arrAllStories                          = array_merge($newStoriesArray,$topStoriesArray,$bestStoriesArray);
            foreach ($arrAllStories as $story){
                $postExist                          = Posts::where(['post_id' => $story['id']])->count();
                if($postExist == 0){
                    $count                          = Posts::count();
                    $postsData                      = [];
                    if($count <= $total){
                        $postsData['created_by']    = $story['by'];
                        $postsData['post_id']       = $story['id'];
                        $postsData['title']         = strip_tags($story['title']);
                        $postsData['created_at']    = Carbon::createFromTimestamp($story['time']);
                        $postsData['comment_ids']   = isset($story['kids']) ? json_encode($story['kids']):null;
                        $postsData['url']           = isset($story['url']) ? trim(stripslashes((string)strip_tags($story['url']))):null;
                        $postsData['comment_count'] = isset($story['descendants']) ? $story['descendants']:null;
                        $postsData['score']         = isset($story['score']) ? $story['score']:null;
                        $postsData['type']          = $story['story_type'];
                        Posts::insert($postsData);
                    }
                }
            }

        }

    }

    /**
     * get best stories
     * @return array
     */
    public static function getBestStories(){
        $allBestStories             = [];
        $arrBestStories             = self::connectionAttempt('https://hacker-news.firebaseio.com/v0/beststories.json?orderBy=%22$key%22&limitToFirst=100');
        if ($arrBestStories) {
            foreach ($arrBestStories as $storyId) {
                $storyData          = self::connectionAttempt('https://hacker-news.firebaseio.com/v0/item/' . $storyId . '.json');
                if (!empty($storyData)) {
                    $storyData['story_type'] = "best";
                    array_push($allBestStories, $storyData);
                }
            }
        }
        return $allBestStories;
    }

    /**
     * get new stories
     * @return array
     */
    public static function getNewStories(){
        $allNewStories          = [];
        $arrNewStories          = self::connectionAttempt('https://hacker-news.firebaseio.com/v0/newstories.json?orderBy=%22$key%22&limitToFirst=220');
        if ($arrNewStories) {
            foreach ($arrNewStories as $storyId) {
                $storyData      = self::connectionAttempt('https://hacker-news.firebaseio.com/v0/item/' . $storyId . '.json');
                if (!empty($storyData)) {
                    $storyData['story_type'] = "new";
                    array_push($allNewStories, $storyData);
                }
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
        $arrTopStories      = self::connectionAttempt('https://hacker-news.firebaseio.com/v0/topstories.json?orderBy=%22$key%22&limitToFirst=220');
        if ($arrTopStories)
        {
            foreach ($arrTopStories as $storyId) {
                $storyData = self::connectionAttempt('https://hacker-news.firebaseio.com/v0/item/' . $storyId . '.json');
                if (!empty($storyData)) {
                    $storyData['story_type'] = "top";
                    array_push($allTopStories, $storyData);
                }
            }
        }
        return $allTopStories;
    }

    /**
     * insert comments for post
     */
    public static function saveCommentsForStories(){

        $commentIds  = Posts::whereNotNull('comment_ids')->get();
        if($commentIds){
            foreach ($commentIds as $arrIds) {
                $arrCommentIds                          = json_decode($arrIds['comment_ids']);

                foreach ($arrCommentIds as $commentId) {
                    $commentData                        = self::connectionAttempt('https://hacker-news.firebaseio.com/v0/item/' . $commentId . '.json');
                    if(!empty($commentData))
                    {
                        $commentExist                       = Comments::where(['comment_id' => $commentData['id']])->count();
                        $story_comment = [];
                        if ($commentExist == 0 && isset($commentData['text'])) {
                            $story_comment['posts_id']      = $arrIds->id;
                            $story_comment['comment']       = strip_tags($commentData['text']);
                            $story_comment['type']          = $commentData['type'];
                            $story_comment['comment_id']    = $commentData['id'];
                            $story_comment['created_by']    = $commentData['by'];
                            $story_comment['belongs_to']    = isset($commentData['parent']) ? $commentData['parent'] : null;
                            $story_comment['kids'] = isset($commentData['kids']) ? json_encode($commentData['kids']) : null;
                            $story_comment['created_at'] = Carbon::createFromTimestamp($commentData['time']);
                            Comments::create($story_comment);
                        }
                    }

                }
            }
        }

    }

    public function getStoryComments($post_id){
        $originalPost   = Posts::find($post_id);
        $comments       = Comments::where('posts_id',$post_id)->latest()->get();

        return view('Comments.comments', compact('originalPost','comments'))->render();
    }

    /**
     *
     */
    public static function saveCommentBelongingToAComment(){
        $commentKidsIds  = Comments::whereNotNull('kids')->get();
        if($commentKidsIds){
            foreach ($commentKidsIds as $arrIds){
                $arrCommentkidIds                           =json_decode($arrIds['kids']);

                foreach ($arrCommentkidIds as $commentKidId) {
                    $commentData                            = self::connectionAttempt('https://hacker-news.firebaseio.com/v0/item/' . $commentKidId . '.json');
                    if(!empty($commentData))
                    {
                        $commentExist                       = Comments::where(['comment_id' => $commentData['id']])->count();
                        $story_comment                      = [];
                        if ($commentExist == 0 && isset($commentData['text'])) {
                            $story_comment['posts_id']      = $arrIds['posts_id'];
                            $story_comment['comment']       = strip_tags($commentData['text']);
                            $story_comment['belongs_to']    = isset($arrIds['parent']) ? $arrIds['parent'] : null;
                            $story_comment['type']          = $commentData['type'];
                            $story_comment['comment_id']    = $commentData['id'];
                            $story_comment['created_by']    = $commentData['by'];
                            $story_comment['kids']          = isset($commentData['kids']) ? json_encode($commentData['kids']) : null;
                            $story_comment['created_at']    = Carbon::createFromTimestamp($commentData['time']);
                            Comments::create($story_comment);
                        }
                    }

                 }

             }
         }
    }

    /**
     * @param $url
     * @return array
     */
    public static function connectionAttempt($url)
    {
        $failAttempt = 0;
        try {
            $data = Http::get($url);
            if ($data->ok()) {
                return $data->json();
            }
        }
        catch (\Exception $e) {

            if ($failAttempt === 5) {
                $failAttempt = 0;
                return [];
            }
            else {
                $failAttempt ++;
                sleep(300);
                self::connectionAttempt($url);
            }
        }
    }

    /**
     *
     */
    public static function requestPostsToBeAdded(){
        dispatch(new GetPostsJob());
    }

    /**
     *
     */
    public static function requestCommentsBelongingToPostsToBeAdded(){
        dispatch(new CreateCommentsJob());
    }

    /**
     *
     */
    public function getCommentsAndReplies(){
        dispatch(new CommentRepliesJob());
    }

}
