<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * 文章提交权限
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //修改权限
    public function update(User $user, Post $post) {
        return $user->id == $post->user_id;
    }

    //删除权限
    public function delete(User $user, Post $post) {
        return $user->id == $post->user_id;
    }


}
