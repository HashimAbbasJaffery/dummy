<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create Job</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #bfdbfe, #e0e7ff);
            margin: 0;
            padding: 3rem 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #1e293b;
        }

        .form-container {
            max-width: 700px;
            width: 100%;
            background: #fff;
            padding: 2.5rem 3rem;
            border-radius: 1.5rem;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e7ff;
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 2rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        textarea,
        input[type="number"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            font-size: 1rem;
            background-color: #f8fafc;
            color: #1e293b;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        button {
            background-color: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            align-self: flex-end;
        }

        button:hover {
            background-color: #2563eb;
        }

        .back-link {
            display: block;
            margin-top: 1.5rem;
            text-align: center;
            color: #2563eb;
            font-weight: 500;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>📝 Create New Job</h1>

    <form action="{{ route('company.jobs.store') }}" method="POST">
        @csrf

        <div>
            <label for="title">Job Title</label>
            <input type="text" id="title" name="title" required />
        </div>

        <div>
            <label for="description">Job Description</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div>
            <label for="skills">Required Skills (comma-separated)</label>
            <input type="text" id="skills" name="skills" placeholder="e.g. Laravel, Vue.js, REST API" required />
        </div>

        <div>
            <label for="threshold">Minimum Match Threshold (0.0 - 1.0)</label>
            <input type="number" step="0.01" min="0" max="1" id="threshold" name="threshold" required />
        </div>

        <button type="submit">🚀 Post Job</button>
    </form>

    <a href="{{ route('company.dashboard') }}" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
