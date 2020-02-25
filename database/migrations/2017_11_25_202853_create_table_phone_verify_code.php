<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePhoneVerifyCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('phone_verify_code')) {
            Schema::create('phone_verify_code', function (Blueprint $table) {
                $table->increments('id');
                $table->char('mobile', 11)->default('')->comment('手机号');
                $table->char('code', 6)->default('')->comment('验证码');
                $table->integer('expire_time')->default(0)->comment('过期时间');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('phone_verify_code')) {
            Schema::dropIfExists('phone_verify_code');
        }
    }
}
