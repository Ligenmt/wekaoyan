<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

//    protected $fillable = [
//        'name', 'mobile', 'password', 'email'
//    ];
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'fullAvatarUrl'
    ];

    public function shuoshuos()
    {
        return $this->hasMany(\App\Model\Shuoshuo::class, 'user_id', 'id');
    }

    public function experiences()
    {
        return $this->hasMany(\App\Model\Experience::class, 'user_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(\App\Model\Question::class, 'user_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(\App\Model\Answer::class, 'user_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(\App\Model\File::class, 'user_id', 'id');
    }

    public function getFullAvatarUrlAttribute()
    {
        return (!empty($this->avatar_url)) ? DATA_URL . $this->avatar_url : '';
    }


}
