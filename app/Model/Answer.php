<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Answer extends BaseModel
{

    protected $guarded = [];

    //上传用户
    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function forum() {
        return $this->belongsTo('App\Model\Forum');
    }

    public function question() {
        return $this->belongsTo('App\Model\Question');
    }

    public function upvote($user_id) {
        return $this->hasOne('App\Model\AnswerUpvote')->where('user_id', $user_id);
    }

    public function upvotes() {
        return $this->hasMany('App\Model\AnswerUpvote', 'answer_id', 'id');
    }
}
