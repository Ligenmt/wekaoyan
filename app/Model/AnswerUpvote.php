<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AnswerUpvote extends BaseModel
{

    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function question() {
        return $this->belongsTo('App\Model\Question');
    }

    public function answer() {
        return $this->belongsTo('App\Model\Answer');
    }
}
