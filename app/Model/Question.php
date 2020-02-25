<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends BaseModel
{

    protected $guarded = [];

    //上传用户
    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function forum() {
        return $this->belongsTo('App\Model\Forum');
    }

    public function focus($user_id) {
        return $this->hasOne('App\Model\QuestionFocusUser')->where('user_id', $user_id);
    }

    public function answers() {
        return $this->hasMany('App\Model\Answer','question_id', 'id');
    }

    public function focususers() {
        return $this->hasMany('App\Model\QuestionFocusUser', 'question_id', 'id');
    }
}
