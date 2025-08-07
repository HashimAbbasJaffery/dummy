<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;

class QuestionnaireController extends Controller
{
    public function get(Application $application) {
        $job = $application->job;
        $answers = $application->questionnaire->answers;
        return view("company.user_questionnaire", compact("job", "application", "answers"));
    }
}
