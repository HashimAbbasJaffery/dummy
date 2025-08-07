<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Candidate Questionnaire</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
<style>
    /* Use your original CSS exactly */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: #f3f4f6;
        padding: 2rem 1rem;
    }
    .container {
        max-width: 1000px;
        margin: 0 auto;
    }
    .form-section {
        background: rgba(17, 24, 39, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 1.5rem;
        padding: 2rem;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(18px);
    }
    .form-section h2 {
        font-size: 2rem;
        font-weight: 800;
        color: #a5b4fc;
        margin-bottom: 1.5rem;
        text-shadow: 0 0 10px #6366f1;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    label {
        font-weight: 600;
        color: #d1d5db;
        margin-bottom: 0.5rem;
        display: block;
    }
    textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #4b5563;
        border-radius: 0.5rem;
        background-color: #1f2937;
        color: #f3f4f6;
        font-size: 1rem;
        resize: vertical;
        min-height: 100px;
        font-family: 'Inter', sans-serif;
    }
    button[type="submit"] {
        background: linear-gradient(90deg, #6366f1, #3b82f6);
        color: white;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        font-weight: 700;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: 0.3s ease;
        box-shadow: 0 0 12px rgba(99, 102, 241, 0.4);
        align-self: flex-start;
    }
    button[type="submit"]:hover {
        background: linear-gradient(90deg, #4f46e5, #2563eb);
        box-shadow: 0 0 16px rgba(99, 102, 241, 0.6);
    }
    @media (max-width: 640px) {
        .form-section h2 {
            font-size: 1.75rem;
        }
    }
</style>
</head>
<body>

<div class="container">
    <div class="form-section">
        <h2>Candidate Questionnaire</h2>
        <form action="{{ route('candidate.questionnaire.answers', [ 'application' => $application->id ]) }}" method="POST">
            @csrf
            <div>
                <label for="q1">1. Can you briefly tell us about yourself and your background?</label>
                <textarea id="q1" name="answers[q1]" required maxlength="1000" placeholder="Write your answer here..."></textarea>
            </div>
            <div>
                <label for="q2">2. Why are you interested in this position?</label>
                <textarea id="q2" name="answers[q2]" required maxlength="1000" placeholder="Write your answer here..."></textarea>
            </div>
            <div>
                <label for="q3">3. What are your strengths and weaknesses?</label>
                <textarea id="q3" name="answers[q3]" required maxlength="1000" placeholder="Write your answer here..."></textarea>
            </div>
            <div>
                <label for="q4">4. How do you handle stress or pressure at work?</label>
                <textarea id="q4" name="answers[q4]" required maxlength="1000" placeholder="Write your answer here..."></textarea>
            </div>
            <div>
                <label for="q5">5. How do you prioritize tasks when working on multiple projects?</label>
                <textarea id="q5" name="answers[q5]" required maxlength="1000" placeholder="Write your answer here..."></textarea>
            </div>
            <div>
                <label for="q6">6. Describe a time when you had a conflict with a colleague. How did you resolve it?</label>
                <textarea id="q6" name="answers[q6]" required maxlength="1000" placeholder="Write your answer here..."></textarea>
            </div>
            <div>
                <label for="q7">7. What motivates you in your professional life?</label>
                <textarea id="q7" name="answers[q7]" required maxlength="1000" placeholder="Write your answer here..."></textarea>
            </div>
            <div>
                <label for="q8">8. Are you more comfortable working independently or in a team?</label>
                <textarea id="q8" name="answers[q8]" required maxlength="1000" placeholder="Write your answer here..."></textarea>
            </div>
            <div>
                <label for="q9">9. What are your career goals over the next 2–5 years?</label>
                <textarea id="q9" name="answers[q9]" required maxlength="1000" placeholder="Write your answer here..."></textarea>
            </div>
            <div>
                <label for="q10">10. Why are you leaving (or did you leave) your previous job?</label>
                <textarea id="q10" name="answers[q10]" required maxlength="1000" placeholder="Write your answer here..."></textarea>
            </div>

            <button type="submit">🚀 Submit Questionnaire</button>
        </form>
    </div>
</div>

</body>
</html>
