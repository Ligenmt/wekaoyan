<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Shuoshuo extends BaseModel
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function forum() {
        return $this->belongsTo('App\Model\Forum');
    }

    public function comment($user_id) {
        return $this->hasOne('App\Model\ShuoshuoComment')->where('user_id', $user_id);
    }

    public function shuoshuocomments() {
        return $this->hasMany('App\Model\ShuoshuoComment', 'shuoshuo_id', 'id');
    }

    public function upvote($user_id) {
        return $this->hasOne('App\Model\ShuoshuoUpvote')->where('user_id', $user_id);
    }

    public function shuoshuoupvotes() {
        return $this->hasMany('App\Model\ShuoshuoUpvote', 'shuoshuo_id', 'id');
    }

}
