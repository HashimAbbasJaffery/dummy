<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Applications - {{ $job->title }}</title>

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

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            justify-content: center;
        }

        .tab {
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            border-radius: 999px;
            cursor: pointer;
            background: #e0e7ff;
            color: #1e3a8a;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .tab.active {
            background: #3b82f6;
            color: #fff;
            border-color: #2563eb;
        }

        .app-card {
            background: #f0f9ff;
            border: 1px solid #dbeafe;
            padding: 1.5rem;
            border-radius: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 6px 16px rgba(191, 219, 254, 0.2);
        }

        .app-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .app-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
        }

        .app-date {
            font-size: 0.875rem;
            color: #64748b;
        }

        .app-body {
            margin-top: 1rem;
        }

        .app-body p {
            margin: 0.25rem 0;
            font-size: 0.95rem;
        }

        .btn {
            display: inline-block;
            margin-top: 0.75rem;
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .btn:hover {
            background-color: #2563eb;
        }

        .cover-letter {
            margin-top: 1rem;
            background: #fff;
            border: 1px dashed #cbd5e1;
            padding: 1rem;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            color: #334155;
        }

        .no-apps {
            text-align: center;
            font-size: 1rem;
            color: #475569;
        }

        [data-tab-content] {
            display: none;
        }

        [data-tab-content].active {
            display: block;
        }

        @media (max-width: 640px) {
            .app-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>📄 Applications for: {{ $job->title }}</h1>

    <div class="tabs">
        <div class="tab active" data-tab="shortlisted">✅ Shortlisted</div>
        <div class="tab" data-tab="not-recommended">🚫 Not Recommended</div>
    </div>

    <div data-tab-content="shortlisted" class="active">
        @php
            $shortlisted = $applications->filter(fn($app) => $app->classification_score >= $job->threshold);
        @endphp

        @forelse($shortlisted as $application)
            <div class="app-card">
                <div class="app-header">
                    <div class="app-name">{{ $application->name }}</div>
                    <div class="app-date">Applied on {{ $application->created_at->format('M d, Y') }}</div>
                </div>

                <div class="app-body">
                    <p><strong>Email:</strong> {{ $application->email }}</p>
                    <p>
                        <strong>Resume:</strong>
                        <a class="btn" href="{{ asset('storage/' . $application->resume) }}" target="_blank">Download</a>
                    </p>
                    <p>
                        <strong>Education Certificate:</strong>
                        <a class="btn" href="{{ asset('storage/' . $application->education_file) }}" target="_blank">Download</a>
                    </p>

                    @if($application->cover_letter)
                        <div class="cover-letter">
                            <strong>Cover Letter:</strong><br>
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="no-apps">No shortlisted applications.</p>
        @endforelse
    </div>

    <div data-tab-content="not-recommended">
        @php
            $rejected = $applications->filter(fn($app) => $app->classification_score < $job->threshold);
        @endphp

        @forelse($rejected as $application)
            <div class="app-card">
                <div class="app-header">
                    <div class="app-name">{{ $application->name }}</div>
                    <div class="app-date">Applied on {{ $application->created_at->format('M d, Y') }}</div>
                </div>

                <div class="app-body">
                    <p><strong>Email:</strong> {{ $application->email }}</p>
                    <p>
                        <strong>Resume:</strong>
                        <a class="btn" href="{{ asset('storage/' . $application->resume) }}" target="_blank">Download</a>
                    </p>
                    <p>
                        <strong>Education Certificate:</strong>
                        <a class="btn" href="{{ asset('storage/' . $application->education_file) }}" target="_blank">Download</a>
                    </p>

                    @if($application->cover_letter)
                        <div class="cover-letter">
                            <strong>Cover Letter:</strong><br>
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="no-apps">No non-recommended applications.</p>
        @endforelse
    </div>
</div>

<script>
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('[data-tab-content]');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            tab.classList.add('active');
            const target = tab.getAttribute('data-tab');
            document.querySelector(`[data-tab-content="${target}"]`).classList.add('active');
        });
    });
</script>

</body>
</html>
