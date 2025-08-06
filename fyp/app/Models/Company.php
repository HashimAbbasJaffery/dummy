<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use App\Models\Project;

class Company extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];
    protected $with = [ 'jobs' ];

    /**
     * Get all of the jobs for the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany(Project::class, "company_id");
    }
}
