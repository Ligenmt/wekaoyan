<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Upvote extends BaseModel
{
    protected $fillable = ['user_id', 'post_id']; //可以注入的属性
}
