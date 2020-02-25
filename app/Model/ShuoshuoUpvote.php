<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShuoshuoUpvote extends BaseModel
{
    protected $guarded = [];
    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function shuoshuo() {
        return $this->belongsTo('App\Model\Shuoshuo');
    }
}
