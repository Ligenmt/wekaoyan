<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends BaseModel
{

    protected $guarded = [];

    //上传用户
    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function counteruser() {
        return $this->belongsTo('App\Model\User', 'counteruser_id', 'id');
    }

    public function shuoshuo() {
        return $this->belongsTo('App\Model\Shuoshuo','shuoshuo_id', 'id');
    }

    public function experience() {
        return $this->belongsTo('App\Model\Experience','experience_id', 'id');
    }

    public function question() {
        return $this->belongsTo('App\Model\Question');
    }
//
//    public function upvote($user_id) {
//        return $this->hasOne('App\AnswerUpvote')->where('user_id', $user_id);
//    }
}
