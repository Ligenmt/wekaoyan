<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Upload extends BaseModel
{

    protected $guarded = [];

    //上传用户
    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function forum() {
        return $this->belongsTo('App\Model\Forum');
    }
}
