<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
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

        .card,
        .form-section {
            background: rgba(17, 24, 39, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(18px);
        }

        .card h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #a5b4fc;
            text-shadow: 0 0 10px #6366f1;
        }

        .card p {
            color: #9ca3af;
            margin-top: 0.5rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #f3f4f6;
            margin-top: 2rem;
            text-shadow: 0 0 5px rgba(165, 180, 252, 0.3);
        }

        .description {
            margin-top: 0.5rem;
            line-height: 1.8;
            color: #cbd5e1;
            white-space: pre-line;
        }

        .skills {
            margin-top: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .skill-badge {
            background-color: rgba(129, 140, 248, 0.1);
            color: #a5b4fc;
            border: 1px solid rgba(165, 180, 252, 0.3);
            border-radius: 999px;
            padding: 0.4rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(99, 102, 241, 0.15);
        }

        .skill-badge:hover {
            background-color: rgba(99, 102, 241, 0.2);
            transform: scale(1.05);
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
            gap: 1.5rem;
        }

        label {
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 0.5rem;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #4b5563;
            border-radius: 0.5rem;
            background-color: #1f2937;
            color: #f3f4f6;
            font-size: 1rem;
        }

        textarea {
            resize: vertical;
        }

        input[type="file"] {
            padding: 0.5rem;
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
        }

        button[type="submit"]:hover {
            background: linear-gradient(90deg, #4f46e5, #2563eb);
            box-shadow: 0 0 16px rgba(99, 102, 241, 0.6);
        }

        @media (max-width: 640px) {
            .card h1,
            .form-section h2 {
                font-size: 1.75rem;
            }

            .section-title {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>

<div class="container">

    {{-- Job Detail Card --}}
    <div class="card">
        <h1>{{ $job->title }}</h1>
        <p>Posted by: <strong>{{ $job->company ?? 'Company Inc.' }}</strong></p>
        <p>Minimum match: {{ $job->threshold * 100 }}%</p>

        <div>
            <h2 class="section-title">Job Description</h2>
            <p class="description">{!! nl2br(e($job->description)) !!}</p>
        </div>

        <div>
            <h2 class="section-title">Required Skills</h2>
            <div class="skills">
                @foreach (explode(',', $job->skills) as $skill)
                    <span class="skill-badge">{{ trim($skill) }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Application Form --}}
    <div class="form-section">
        <h2>Apply for this Job</h2>

        <form action="{{ route('jobs.apply', ['id' => $job->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="name">Full Name</label>
                <input id="name" name="name" type="text" required>
            </div>

            <div>
                <label for="email">Email Address</label>
                <input id="email" name="email" type="email" required>
            </div>

            <div>
                <label for="resume">Resume (PDF only)</label>
                <input id="resume" name="resume" type="file" accept="application/pdf" required>
            </div>

            <div>
                <label for="education_file">Education Certificate (PDF only)</label>
                <input id="education_file" name="education_file" type="file" accept="application/pdf" required>
            </div>

            <div>
                <label for="cover_letter">Cover Letter</label>
                <textarea id="cover_letter" name="cover_letter" rows="5"></textarea>
            </div>

            <button type="submit">🚀 Submit Application</button>
        </form>
    </div>
</div>

</body>
</html>
