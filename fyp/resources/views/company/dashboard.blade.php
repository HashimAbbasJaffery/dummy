<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Company Dashboard</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary: #1e40af;
            --secondary: #3b82f6;
            --light-blue: #eff6ff;
            --border-blue: #dbeafe;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #bfdbfe, #e0e7ff, #bfdbfe);
            margin: 0;
            padding: 3rem 1rem;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            color: #1e293b;
        }

        .dashboard-container {
            background-color: white;
            max-width: 920px;
            width: 100%;
            padding: 3rem;
            border-radius: 1.75rem;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-blue);
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .dashboard-header h1 {
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--primary);
        }

        .dashboard-header p {
            color: #475569;
            font-size: 1.05rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--border-blue);
            padding-bottom: 0.4rem;
        }

        .job-list {
            display: grid;
            gap: 1.25rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .job-card {
            background: var(--light-blue);
            padding: 1.25rem 1.75rem;
            border-radius: 1rem;
            border: 1px solid var(--border-blue);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.25s ease;
        }

        .job-card:hover {
            background-color: #dbeafe;
            transform: translateY(-2px);
        }

        .job-info {
            max-width: 75%;
        }

        .job-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .job-date {
            font-size: 0.875rem;
            color: #64748b;
        }

        .btn-view-applications {
            background-color: var(--secondary);
            color: white;
            padding: 0.5rem 1.2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-view-applications:hover {
            background-color: #2563eb;
        }

        .no-jobs {
            text-align: center;
            font-size: 1rem;
            color: #475569;
            margin-top: 2rem;
        }

        .no-jobs a {
            color: var(--secondary);
            text-decoration: underline;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            .dashboard-container {
                padding: 2rem;
            }

            .job-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .job-info {
                max-width: 100%;
            }

            .btn-view-applications {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <header class="dashboard-header">
        <h1>Welcome, {{ auth()->guard('company')->user()->name ?? 'Company' }}</h1>
        <p>Manage your job postings and view received applications</p>
    </header>

    <a href="{{ route('company.jobs.create') }}" class="btn-view-applications">
        Create Jobs
    </a>
    <section>
        <h2 class="section-title">Your Job Postings</h2>
            @if($jobs->count())
                <ul class="job-list">
                    @foreach($jobs as $job)
                        <li class="job-card">
                            <div class="job-info">
                                <div class="job-title">{{ $job->title }}</div>
                                <div class="job-date">Posted on {{ $job->created_at->format('M d, Y') }}</div>
                            </div>
                            <a href="{{ route('company.jobs.applications', $job->id) }}" class="btn-view-applications">
                                View Applications
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="no-jobs">
                No job postings found. <br>
                <a href="{{ route('company.jobs.create') }}">Post your first job →</a>
            </div>
        @endif
    </section>
</div>

</body>
</html>
