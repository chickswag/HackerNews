<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';
    public $timestamps = true;
    protected $fillable =['posts_id','comment','type','created_at','comment_id','created_by','belongs_to','kids'];


}
