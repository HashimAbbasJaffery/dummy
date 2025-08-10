<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Application;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationShortlisted;
use App\Mail\ApplicationRejected;

use Illuminate\Support\Facades\Http;

class JobController extends Controller
{
    // Show all jobs
    public function index()
    {
        $jobs = Project::latest()->paginate(10);
        return view('jobs.index', compact('jobs'));
    }

    // Show single job detail
    public function show($id)
    {
        $job = Project::find($id);
        return view('jobs.job', compact('job'));
    }

    // Handle job application
 public function apply(Request $request, $id)
    {
        // Find the job/project or fail
        $job = Project::findOrFail($id);

        // Validate form data & files
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'education_file' => 'required|file|mimes:pdf|max:2048',
            'cover_letter' => 'nullable|string',
        ]);

        // Store uploaded files in public storage
        $resumePath = $request->file('resume')->store('resumes', 'public');
        $educationFilePath = $request->file('education_file')->store('education_files', 'public');

        // Read resume file content for sending to Flask API
        $resumeFilePathFull = storage_path('app/public/' . $resumePath);

        $response = Http::attach(
            'resume',
            file_get_contents($resumeFilePathFull),
            $request->file('resume')->getClientOriginalName()
        )->post('http://127.0.0.1:5000/api/classify', [
            'jd' => $job->description . " Skills: " .  strtolower($job->skills),
            'threshold' => $job->threshold
        ]);

        if ($response->failed()) {
            return back()->withErrors(['api_error' => 'Failed to classify resume. Please try again later.']);
        }

        $result = $response->json();

        // Save the application with classification results
        $application = Application::create([
            'job_id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'resume_path' => $resumePath,
            'education_file_path' => $educationFilePath,
            'cover_letter' => $request->cover_letter,
            'classification_label' => $result['label'] ?? null,
            'classification_score' => $result['final_score'] ?? null,
        ]);

        if (($result['label'] ?? '') === 'Recommended') {
            Mail::to($request->email)->send(new ApplicationShortlisted($request->name, $job->title, $application));
        } else {
            Mail::to($request->email)->send(new ApplicationRejected($request->name, $job->title));
        }

        return back()->with('success', 'Application submitted successfully! Classification: ' . ($result['label'] ?? 'Unknown'));
    }

    public function questionnaire(Application $application) {
        $answers = $application->questionnaire->answers ?? [];
        $candidate_score = $application->classification_score;
        $min_required_score = $application->job->threshold;

        if($candidate_score >= $min_required_score) {
            return view("questionnaire.view", compact("application", "answers"));
        }
    }
}
