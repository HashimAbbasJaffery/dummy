<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Job;
use App\Models\Project;
use App\Models\Questionnaire;

class Application extends Model
{
    protected $guarded = [ "id", "created_at", "updated_at" ];
    protected $with = ["questionnaire"];

    public function job() {
        return $this->belongsTo(Project::class, 'job_id');
    }

    public function questionnaire() {
        return $this->hasOne(Questionnaire::class, "application_id");
    }
}
