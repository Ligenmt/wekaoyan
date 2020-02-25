<?php

namespace App\Http\ViewComposers;

use App\Libs\Topbar;
use Illuminate\Http\Request;
use Illuminate\View\View;


class TopbarComposer {


    private $data = null;//CommonUtils对象

    public function __construct(Request $request) {
        $this->data = new Topbar($request);//新建一个CommonUtils对象
    }

    public function compose(View $view) {
        $view->with([
            'menu' => $this->data->menu,
            'forum_id' => $this->data->forum_id,
            'forum_name' => $this->data->forum_name,
            'nofi_count' => $this->data->nofi_count,
            'forums' => $this->data->forums,
            'teacher_focus' => $this->data->teacher_focus
        ]);//填充数据
    }


}