<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Login</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #cfe8fc, #ffffff, #dbeafe);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .card {
            background: white;
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #eee;
        }

        .card h2 {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            display: block;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        label {
            font-size: 14px;
            color: #444;
            margin-bottom: 0.25rem;
            display: block;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.6rem 0.8rem;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: border 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #3b82f6;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .remember-forgot a {
            color: #2563eb;
            text-decoration: none;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: #555;
        }

        .checkbox-label input {
            width: 16px;
            height: 16px;
        }

        button[type="submit"] {
            background-color: #2563eb;
            color: white;
            padding: 0.6rem;
            font-weight: 600;
            font-size: 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #1e40af;
        }

        .register-link {
            margin-top: 1rem;
            font-size: 14px;
            text-align: center;
            color: #555;
        }

        .register-link a {
            color: #2563eb;
            font-weight: 500;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-box {
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 1rem;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 1rem;
        }

        .error-box ul {
            list-style: disc;
            margin-left: 1rem;
        }
    </style>
</head>
<body>

    <div class="card">
        <img src="https://via.placeholder.com/100x100?text=Logo" alt="Company Logo" class="logo">

        <h2>Company Login</h2>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li> {{ $error }} </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('company.login') }}">
            @csrf

            <div>
                <label for="email">Company Email</label>
                <input type="email" id="email" name="email" placeholder="company@example.com" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="remember-forgot">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    Remember Me
                </label>
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit">Login</button>

            <div class="register-link">
                Not registered? <a href="#">Create a company account</a>
            </div>
        </form>
    </div>

</body>
</html>
