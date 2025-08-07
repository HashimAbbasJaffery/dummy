<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index() {
        $jobs = auth("company")->user()->jobs;
        return view("company.dashboard", compact("jobs"));
    }

    public function create() {
        return view("company.create");
    }

    public function store() {
        request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'skills' => 'required|string',
            'threshold' => 'required|numeric|between:0,1',
            'total_vacancies' => 'required|numeric'
        ]);

        auth('company')->user()->jobs()->create([
            'title' => request()->title,
            'description' => request()->description,
            'skills' => request()->skills,
            'threshold' => request()->threshold,
            'total_vacancies' => request()->total_vacancies
        ]);

        return redirect()->route('company.dashboard')->with('success', 'Job created successfully!');

    }


}
