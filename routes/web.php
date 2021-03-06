<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::redirect('/', '/Posts');
Route::resource('Posts', 'PostsController');
Route::get('/Posts','PostsController@index')->name('posts');
Route::get('/Posts/story/{type}','PostsController@filterByType')->name('filter');
Route::get('/Posts/comment/{item}','PostsController@getStoryComments')->name('comment-item');
Route::get('/FetchPosts','PostsController@requestPostsToBeAdded')->name('fetch-posts');
Route::get('/Comments','PostsController@requestCommentsBelongingToPostsToBeAdded')->name('comments');
Route::get('/CommentsReplies','PostsController@getCommentsAndReplies')->name('replies-interaction');



