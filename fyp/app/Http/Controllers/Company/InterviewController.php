<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Mail\ApplicationInterview;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class InterviewController extends Controller
{
    public function interview(Request $request, Application $application) {
    $request->validate([
        'interview_time' => 'required',
        'interview_date' => 'required|date',
        'location' => 'required|string|max:255',
    ]);

    $application->interview_time = $request->interview_time;
    $application->interview_date = $request->interview_date;
    $application->location = $request->location;

    $application->interview_invitation = true;
    $application->save();

    $data = [
        "candidate_name" => $application->name,
        "position" => $application->job->title,
        "interview_time" => $request->interview_time,
        "interview_date" => $request->interview_date,
    ];

    Mail::to($application->email)->send(new ApplicationInterview($data));

    return response()->json(['message' => 'Interview invitation sent']);
    }
}
