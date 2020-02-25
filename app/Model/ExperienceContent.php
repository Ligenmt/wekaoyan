<?php

namespace App\Model;


class ExperienceContent extends BaseModel
{
    protected $table = "experience_contents";
    protected $guarded = [];
    public function experience() {
        return $this->belongsTo('App\Model\Experience');
    }

}
