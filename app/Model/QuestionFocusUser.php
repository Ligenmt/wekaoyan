<?php

namespace App\Model;


class QuestionFocusUser extends BaseModel
{
    protected $table = "question_focus_users";
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function question() {
        return $this->belongsTo('App\Model\Question');
    }
}
