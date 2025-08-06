<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Project;

class ApplicationController extends Controller
{
    public function index($id) {
        $job = Project::find($id);
        $applications = $job->applications;
        return view("company.applications", compact("applications", "job"));
    }
}
