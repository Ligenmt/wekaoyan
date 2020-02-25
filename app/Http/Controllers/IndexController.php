<?php

namespace App\Http\Controllers;

use App\Model\Forum;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class IndexController extends Controller
{
    public function index()
    {

        $user = \Auth::user();
        if ($user) {
            $forum_id = $user->forum_id;
        } else {
            $forum_id = session('forum_id');
            if (empty($forum_id)) {
                return redirect('/search');
            }
        }
        return redirect('/examdata');
    }

    function search()
    {
        $forums = Forum::all();
        $targetForumId = \request('id');
//        dd($targetForumId);
        return view('index/searchforum', compact('forums', 'targetForumId'));
    }


}
