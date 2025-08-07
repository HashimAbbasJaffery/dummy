<!DOCTYPE html>
<html>
<head>
    <title>Shortlisted</title>
</head>
<body>
    <p>Dear {{ $name }},</p>

    <p>Congratulations! You have been shortlisted for the position of <strong>{{ $jobTitle }}</strong>.</p>

    <p>We would like you to fill the questionnaire form: {{ route('job.questionnaire', [ 'application' => $application->id ]) }}</p>

    <p>We will contact you shortly with further details.</p>

    <p>Best regards,<br>Your Company</p>
</body>
</html>
