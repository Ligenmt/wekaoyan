<?php

namespace App\Http\Controllers;

use App\Http\Constants\NotificationType;
use App\Http\Constants\ResponseCode;
use App\Model\Experience;
use App\Model\ExperienceContent;
use App\Model\Notification;
use App\Model\ExperienceComment;
use App\Model\ExperienceUpvote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExperienceController extends Controller
{

    public function index(Request $request)
    {
        $forum_id = session('forum_id');
        $experiences = Experience::where('forum_id', $forum_id)
            ->with(['user'])
            ->withCount(['experiencecomments', 'experienceupvotes'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['id', 'title', 'user_id', 'count', 'forum_id', 'created_at', 'updated_at']);
//        dd($experiences);
        //预加载
//        $experiences->load('user');

        return view('experience/index', compact('experiences'));
    }

    public function post()
    {

        $user = \Auth::user();
        if ($user == null) {
            return view('unlogin');
        }

        return view('experience/post');
    }

    public function doPost()
    {
        $user = \Auth::user();
        if ($user == null) {
            return view('unlogin');
        }

        $this->validate(request(), [
            'content' => 'required|string|min:10'
        ], [
            'content.min' => '文章内容过短',
        ]);
        $forum_id = session('forum_id');

        $user_id = \Auth::id();
        $experience = new Experience();
        $experience->user_id = $user_id;
        $experience->title = request('title');
//        $experience->content = request('content');
        $experience->forum_id = $forum_id;
        $experience->save();

        $experienceContent = new ExperienceContent();
        $experienceContent->experience_id = $experience->id;
        $experienceContent->content = \request('content');
        $experienceContent->save();

        return redirect('experience');

    }

    public function show($experience_id)
    {

        $experience = Experience::where('id', $experience_id)
            ->with([
                'user',
                'experiencecomments',
                'experiencecomments.user',
                'experiencecomments.parent',
                'experiencecomments.parent.user'
            ])
            ->withCount(['experiencecomments', 'experienceupvotes'])
            ->first();
        $experienceContent = ExperienceContent::where('experience_id', $experience_id)->first();
        //Experience::where('id', $experience_id)->update(['count'=>$experience->count+1]);
        $bool = DB::update('update experiences set count = count+1 where id= ? ', [$experience->id]);
        return view('experience/show', compact('experience', 'experienceContent'));
    }

    public function postComment(Experience $experience)
    {

        if (!\Auth::check()) {
            return [
                'code' => ResponseCode::未登录,
                'msg' => '尚未登录'
            ];
        }

        $content = request('content');
        $user_id = \Auth::id();

        $comment = new ExperienceComment();
        $comment->user_id = $user_id;
        $comment->content = $content;
        $comment->experience_id = $experience->id;
        $parent_id = request('parent_id');
        if ($parent_id != null) {
            $comment->parent_id = $parent_id;
        }

        $comment->save();
        // 提醒评论
        $notf = new Notification();
        $notf->type = NotificationType::文章评论;
        $notf->experience_id = $experience->id;
        $notf->user_id = $experience->user->id;
        $notf->counteruser_id = $user_id;
        $notf->is_read = false;
        $notf->save();
        //提醒回复评论
        if ($parent_id != null) {
            $parentComment = ExperienceComment::find($parent_id);
            $notf2 = new Notification();
            $notf2->user_id = $parentComment->user_id;
            $notf2->counteruser_id = $user_id;
            $notf2->type = NotificationType::回复文章评论;
            $notf2->experience_id = $experience->id;;
            $notf2->is_read = false;
            $notf2->save();
        }

        return [
            'code' => '200',
            'msg' => 'success'
        ];

    }

    public function postUpvote(Experience $experience)
    {

        if (!\Auth::check()) {
            return [
                'code' => ResponseCode::未登录,
                'msg' => '尚未登录'
            ];
        }
        $user_id = \Auth::id();
        if ($experience->upvote(\Auth::id())->exists()) {
            $experience->upvote(\Auth::id())->delete();
            return [
                'code' => '200',
                'msg' => 'success',
                'upvote' => false
            ];
        }
        $upvote = new ExperienceUpvote();
        $upvote->user_id = $user_id;
        $upvote->experience_id = $experience->id;
        $upvote->save();
        //提醒文章点赞
        $notf = new Notification();
        $notf->type = NotificationType::文章点赞;
        $notf->experience_id = $experience->id;
        $notf->user_id = $experience->user->id;
        $notf->counteruser_id = $user_id;
        $notf->is_read = false;
        $notf->save();

        return [
            'code' => '200',
            'msg' => 'success',
            'upvote' => true
        ];
    }
}
