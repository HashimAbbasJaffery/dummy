<!DOCTYPE html>
<html>
<head>
    <title>Interview Invitation</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333333;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 30px;
            background-color: #f9fafb;
        }
        h2 {
            color: #1e40af;
        }
        p {
            font-size: 16px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Interview Invitation</h2>
        
        <p>Dear {{ $data['candidate_name'] }},</p>
        
        <p>
            We are pleased to invite you to a technical interview for the position of <strong>{{ $data['position'] }}</strong>.
        </p>

        <p>
            Your interview is scheduled for 
            <strong>{{ \Carbon\Carbon::parse($data['interview_date'])->format('F j, Y') }}</strong> at 
            <strong>{{ \Carbon\Carbon::parse($data['interview_time'])->format('g:i A') }}</strong>.
        </p>
        
        <p>
            Please be prepared and available at the scheduled time. If you have any questions or need to reschedule, feel free to contact us.
        </p>
        
        <p>We look forward to speaking with you.</p>
        
        <p>Best regards,<br>Your Company</p>

        <div class="footer">
            <p>This is an automated message. Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
