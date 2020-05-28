<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable =['title','by','time','comment_ids','url','comment_count','score','type','url'];


}
