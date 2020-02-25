<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TeacherFocusForum extends BaseModel
{

    protected $guarded = [];
    protected $table = "teacher_focus_forums";

    //上传用户
    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function forum() {
        return $this->belongsTo('App\Model\Forum');
    }

    public function forums() {
        return $this->hasMany('App\Model\Forum', 'id', 'forum_id');
    }
}
