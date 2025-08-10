<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class QuestionnaireController extends Controller
{
    public function store(Request $request, Application $application) {
        $answers = $request->answers;

        if($application->questionnaire) {
            // If questionnaire already exists, update it
            $application->questionnaire->update([
                'answers' => $answers
            ]);
        } else {
            // Create a new questionnaire if it doesn't exist
            $application->questionnaire()->create([
                'answers' => $answers
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Your questionnaire was submitted successfully!');
    }
}
