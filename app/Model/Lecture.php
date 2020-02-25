<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lecture extends BaseModel
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function major() {
        return $this->belongsTo('App\Model\Major');
    }

}
