<?php

namespace App\Jobs;

use App\Http\Constants\NotificationType;
use App\Model\Notification;
use App\Model\TeacherFocusForum;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class QuestionNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $forum_id = null;
    protected $user_id = null;
    protected $question_id = null;



    public function __construct($forum_id, $user_id, $question_id)
    {
        $this->forum_id = $forum_id;
        $this->user_id = $user_id;
        $this->question_id = $question_id;

    }

    public function handle()
    {
        try {
            $tffs = TeacherFocusForum::where('forum_id', $this->forum_id)->get();
            foreach ($tffs as $tff) {
                $notf = new Notification();
                $notf->user_id = $tff->user_id;
                $notf->counteruser_id = $this->user_id;
                $notf->type = NotificationType::关注板块提问;
                $notf->question_id = $this->question_id;
                $notf->is_read = false;
                $notf->save();
            }
            \Log::info("question nofitications sent");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }

    }
}
