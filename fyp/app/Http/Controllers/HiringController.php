<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationAccepted;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class HiringController extends Controller
{
    public function hire(Application $application) {
        $application->is_hired = true;
        $application->save();

        Mail::to($application->email)
            ->send(new ApplicationAccepted($application->name, $application->job->title));

        return redirect()->back()
            ->with('success', 'Candidate hired successfully! An email has been sent to the candidate.');
    }
}
