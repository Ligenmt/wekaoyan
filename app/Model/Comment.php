<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends BaseModel
{
    //评论所属文章
    public function post() {
        return $this->belongsTo('App\Model\Post');
    }

    //评论所属用户
    public function user() {
        return $this->belongsTo('App\Model\User');
    }
}
