<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class ShuoshuoComment extends BaseModel
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function parent() {
        return $this->belongsTo('App\Model\ShuoshuoComment', 'parent_id');
    }

    public function shuoshuo() {
        return $this->belongsTo('App\Model\Shuoshuo');
    }
}
