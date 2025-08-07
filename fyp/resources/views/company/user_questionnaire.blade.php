<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Questionnaire - {{ $application->name }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #bfdbfe, #e0e7ff);
            margin: 0;
            padding: 3rem 1rem;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            justify-content: center;
        }

        .container {
            max-width: 960px;
            width: 100%;
            background: #ffffff;
            border-radius: 1.5rem;
            padding: 2.5rem 3rem;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e7ff;
        }

        h1 {
            font-size: 2rem;
            color: #1e40af;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
        }

        .questionnaire-card {
            background: #f0f9ff;
            border: 1px solid #dbeafe;
            padding: 1.5rem;
            border-radius: 1.25rem;
            margin-bottom: 2rem;
            box-shadow: 0 6px 16px rgba(191, 219, 254, 0.2);
        }

        .q-header {
            font-weight: 600;
            font-size: 1.125rem;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .q-block {
            margin-bottom: 1.5rem;
        }

        .q-block label {
            font-weight: 600;
            color: #334155;
            display: block;
            margin-bottom: 0.5rem;
        }

        .q-block p {
            background-color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px dashed #cbd5e1;
            font-size: 0.95rem;
            color: #334155;
            white-space: pre-wrap;
        }

        @media (max-width: 640px) {
            .q-header {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>📝 Questionnaire – {{ $application->name }}</h1>

    <div class="questionnaire-card">
        <div class="q-header">Submitted on {{ $application->created_at->format('M d, Y') }}</div>

        @php
            $questions = [
                'q1' => '1. Can you briefly tell us about yourself and your background?',
                'q2' => '2. Why are you interested in this position?',
                'q3' => '3. What are your strengths and weaknesses?',
                'q4' => '4. How do you handle stress or pressure at work?',
                'q5' => '5. How do you prioritize tasks when working on multiple projects?',
                'q6' => '6. Describe a time when you had a conflict with a colleague. How did you resolve it?',
                'q7' => '7. What motivates you in your professional life?',
                'q8' => '8. Are you more comfortable working independently or in a team?',
                'q9' => '9. What are your career goals over the next 2–5 years?',
                'q10'=> '10. Why are you leaving (or did you leave) your previous job?',
            ];
        @endphp

        @foreach($answers as $key => $answer)
            <div class="q-block">
                <label>{{ $questions[$key] }}</label>
                <p>{{ $answer }}</p>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
