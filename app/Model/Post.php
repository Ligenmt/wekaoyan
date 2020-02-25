<?php
/**
 * Created by PhpStorm.
 * User: ligen
 * Date: 2017/8/22
 * Time: 下午10:50
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

//对应表posts
class Post extends BaseModel {

    protected $table = "posts";

    protected $guarded = []; //不可以注入的属性
    protected $fillable = ['title', 'content']; //可以注入的属性

    //关联用户
    public function user() {
        return $this->belongsTo('App\Model\User');
    }
    //关联评论
    public function comments() {

        return $this->hasMany('App\Model\Comment')->orderBy('created_at', 'desc');
    }
    //关联赞
    public function upvote($user_id) {
        return $this->hasOne('App\Model\Upvote')->where('user_id', $user_id);
    }

    public function upvotes() {
        return $this->hasMany('App\Model\Upvote');
    }
}
