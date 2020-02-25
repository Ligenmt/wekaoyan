<?php

namespace App\Http\Controllers;


use App\Model\File;
use \App\Model\Upload;


class ZhentiController extends Controller
{

    public function index()
    {

        $forum_id = session('forum_id');
//        if (empty($forum_id)) {
//            return redirect('/search');
//        }


        return view('zhenti/index');
    }

}
