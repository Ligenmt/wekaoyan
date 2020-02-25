<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserOperateLog extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $guarded = [];
    protected $table = 'user_operate_log';
    protected $fillable = [
        'user_id',
        'uri',
        'get_params',
        'post_params',
        'ua',
        'ip',
        'note',
    ];

}
