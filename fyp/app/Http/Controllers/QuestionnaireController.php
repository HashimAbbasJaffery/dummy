<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class QuestionnaireController extends Controller
{
    public function store(Request $request, Application $application) {
        $answers = $request->answers;

        $application->questionnaire()->create([
            "answers" => $answers
        ]);
        
        dd(json_encode($answers));
    }
}
