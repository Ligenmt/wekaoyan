<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Experience extends BaseModel
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function comment($user_id) {
        return $this->hasOne('App\Model\ExperienceComment')->where('user_id', $user_id);
    }

    public function experiencecomments() {
        return $this->hasMany('App\Model\ExperienceComment', 'experience_id', 'id');
    }

    public function upvote($user_id) {
        return $this->hasOne('App\Model\ExperienceUpvote')->where('user_id', $user_id);
    }

    public function experienceupvotes() {
        return $this->hasMany('App\Model\ExperienceUpvote', 'experience_id', 'id');
    }
}
