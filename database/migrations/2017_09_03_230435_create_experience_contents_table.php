<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienceContentsTable extends Migration
{
    public function up()
    {
        Schema::create('experience_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('experience_id')->default(0);
            $table->longText('content');
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
        Schema::dropIfExists('experience_contents');
    }
}
