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


Route::get('/Posts', function () {
    return view('Posts.posts');

});

Route::redirect('/', '/Posts');

Route::prefix('api')->group(function() {
    Route::resource('Posts', 'PostsController');
    Route::get('/Posts','PostsController@index')->name('posts');
    Route::get('/fetchPosts','PostsController@fetchPosts')->name('getposts');
    Route::get('/linkComments','PostsController@saveCommentsForStories')->name('link_comments');
    Route::get('/Posts/story/{type}','PostsController@filterByType')->name('filter');
    Route::get('/Posts/comment/{item}','PostsController@getStoryComments')->name('comments');
    Route::get('/Posts/job','PostsController@runScheduleJobInTheBackground')->name('schedule');
});

