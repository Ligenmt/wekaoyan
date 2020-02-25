<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile')->unique();
            $table->string('name')->default('');
            $table->string('qq')->default('');
            $table->string('weixin')->default('');
            $table->string('email')->default('');
            $table->string('avatar_url')->default('');
            $table->boolean('is_teacher')->default(false);
            $table->integer('forum_id')->default(1);
            $table->string('password');
            $table->string('comment');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
