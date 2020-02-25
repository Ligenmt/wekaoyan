<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');  //收到提醒的人
            $table->string('content');
            $table->integer('counteruser_id'); //触发提醒的人
            $table->integer('shuoshuo_id');
            $table->integer('experience_id');
            $table->integer('question_id');
            $table->integer('answer_id');
            $table->boolean('is_read'); //已阅
            $table->integer('type'); //提醒类型  1 说说点赞  2 说说评论  3 文章点赞  4 文章评论  5 回答问题  6 答案点赞
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
        Schema::dropIfExists('notifications');
    }
}
