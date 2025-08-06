<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Listings</title>
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
            color: #e2e8f0;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            font-size: 3rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(90deg, #3b82f6, #6366f1, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: hueShift 10s infinite linear;
        }

        @keyframes hueShift {
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(360deg); }
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            padding: 1.75rem;
            backdrop-filter: blur(16px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }

        .card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35);
        }

        .logo {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(59, 130, 246, 0.2);
            padding: 0.6rem;
            border-radius: 50%;
        }

        .logo svg {
            width: 24px;
            height: 24px;
            stroke: #60a5fa;
            animation: bounce 2s infinite ease-in-out;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .card h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #93c5fd;
            margin-bottom: 0.5rem;
        }

        .card h2:hover {
            text-decoration: underline;
        }

        .description {
            font-size: 0.875rem;
            color: #cbd5e1;
            margin-top: 0.5rem;
            line-height: 1.6;
        }

        .skills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .skill-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.8rem;
            background-color: rgba(99, 102, 241, 0.1);
            color: #a5b4fc;
            border: 1px solid rgba(165, 180, 252, 0.3);
            border-radius: 999px;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
            transition: transform 0.2s ease;
        }

        .skill-badge:hover {
            transform: scale(1.05);
        }

        .btn-view {
            display: inline-block;
            margin-top: 1.5rem;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.65rem 1.5rem;
            border: none;
            border-radius: 999px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            background: linear-gradient(90deg, #2563eb, #4f46e5);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.6);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>🚀 Explore Exciting Career Opportunities</h1>

    <div class="grid">
        @foreach ($jobs as $job)
            <div class="card">
                <div class="logo">
                    <svg fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9.75 17L6 20.25M6 20.25L2.25 16.5M6 20.25V10.5a.75.75 0 011.5 0v9.75zM21 12.75L15.75 9m0 0L21 5.25M15.75 9v9.75a.75.75 0 001.5 0V9z"/>
                    </svg>
                </div>

                <h2>{{ $job->title }}</h2>

                <p class="description">{{ Str::limit($job->description, 100) }}</p>

                <div class="skills">
                    @foreach (explode(',', $job->skills) as $skill)
                        <span class="skill-badge">{{ trim($skill) }}</span>
                    @endforeach
                </div>

                <a href="{{ route('jobs.show', $job->id) }}" class="btn-view">View Job →</a>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
