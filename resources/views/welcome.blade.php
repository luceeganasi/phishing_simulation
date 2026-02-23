<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Phishing Simulation | Security Awareness</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            max-width: 620px;
            width: 100%;
            overflow: hidden;
        }

        .header {
            background-color: #1a56db;
            padding: 30px;
            text-align: center;
        }

        .header .shield-icon img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .header h1 {
            color: #ffffff;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .badge {
            display: inline-block;
            background-color: #fbbf24;
            color: #1f2937;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-top: 10px;
        }

        .body {
            padding: 36px 40px;
        }

        .alert-box {
            background-color: #eff6ff;
            border-left: 4px solid #1a56db;
            border-radius: 6px;
            padding: 18px 20px;
            margin-bottom: 24px;
        }

        .alert-box p {
            color: #1e40af;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.5;
        }

        .message {
            color: #374151;
            font-size: 15px;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .info-list {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 20px 24px;
            margin-bottom: 24px;
        }

        .info-list h3 {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-list ul {
            list-style: none;
            padding: 0;
        }

        .info-list ul li {
            color: #4b5563;
            font-size: 14px;
            padding: 6px 0;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .info-list ul li:last-child {
            border-bottom: none;
        }

        .info-list ul li::before {
            content: "✓";
            color: #10b981;
            font-weight: 700;
            flex-shrink: 0;
        }

        .footer-note {
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .footer-note a {
            color: #1a56db;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-note a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">

        {{-- Header --}}
        <div class="header">
            <div class="shield-icon">
                <img src="{{ asset('images/dmmmsu.png') }}" alt="DMMMSU Logo">
            </div>
            <h1>Security Awareness Notice</h1>
            <span class="badge">Authorized Exercise</span>
        </div>

        {{-- Body --}}
        <div class="body">

            {{-- Main Alert --}}
            <div class="alert-box">
                <p>⚠️ This is for Phishing Simulation as part of a Security Hardening exercise.</p>
            </div>

            {{-- Message --}}
            <p class="message">
                You have accessed a <strong>simulated phishing page</strong>. No real threat has occurred.
                This exercise was conducted by your organization's IT Security team to evaluate and improve
                employee awareness against phishing attacks.
            </p>

            <p class="message">
                Your interaction with this simulation has been logged for training and reporting purposes.
                No personal credentials or sensitive data have been compromised.
            </p>

            {{-- Key Points --}}
            <div class="info-list">
                <h3>What This Means</h3>
                <ul>
                    <li>This page is part of an authorized internal security exercise.</li>
                    <li>Your response has been recorded for awareness training purposes.</li>
                    <li>No actual systems, data, or accounts were put at risk.</li>
                    <li>Phishing training helps strengthen your organization's security posture.</li>
                </ul>
            </div>

            {{-- Footer --}}
            <div class="footer-note">
                For questions, contact your
                <a href="mailto:{{ config('mail.security_team', 'security@yourcompany.com') }}">
                    IT Security Team
                </a>
                &mdash; {{ now()->format('Y') }} &copy; {{ config('app.name', 'Your Organization') }}
            </div>

        </div>
    </div>

</body>
</html>