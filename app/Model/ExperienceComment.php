<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExperienceComment extends BaseModel
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function experience() {
        return $this->belongsTo('App\Model\Experience');
    }

    public function parent() {
        return $this->belongsTo('App\Model\ExperienceComment', 'parent_id');
    }
}
