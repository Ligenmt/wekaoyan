<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ComposerServiceProvider extends ServiceProvider {


    //在boot方法中定义要监听的视图
    public function boot() {
        // 基于类的view composer
        View::composer(
            ['shuoshuo.*',
                'experience.*',
                'question.*',
                'answer.*',
                'examdata.*',
                'user.*',
                'zhenti.*'
            ], 'App\Http\ViewComposers\TopbarComposer'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        //
    }



}