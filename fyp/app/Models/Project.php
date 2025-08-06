<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Project extends Model
{
    protected $guarded = [ "id", "created_at", "updated_at" ];
    public function applications() {
        return $this->hasMany(Application::class, "job_id");
    }
}
