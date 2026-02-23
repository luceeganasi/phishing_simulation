<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Phishing Simulation | Security Awareness</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
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

        .body { padding: 36px 40px; }

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

        /* Capture Form */
        .capture-form {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .capture-form h3 {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group { margin-bottom: 14px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-group input[type="email"] {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            color: #111827;
            background-color: #ffffff;
            transition: border-color 0.2s;
        }

        .form-group input[type="email"]:focus {
            outline: none;
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #1a56db;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 6px;
        }

        .submit-btn:hover { background-color: #1e429f; }
        .submit-btn:disabled { background-color: #93c5fd; cursor: not-allowed; }

        .success-box {
            display: none;
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
            border-radius: 6px;
            padding: 16px 20px;
            margin-top: 16px;
        }

        .success-box p { color: #065f46; font-size: 14px; font-weight: 500; }

        .error-box {
            display: none;
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            border-radius: 6px;
            padding: 16px 20px;
            margin-top: 16px;
        }

        .error-box p { color: #991b1b; font-size: 14px; }

        .location-required {
            display: none;
            background-color: #fff7ed;
            border-left: 4px solid #f97316;
            border-radius: 6px;
            padding: 16px 20px;
            margin-top: 16px;
        }

        .location-required p { color: #9a3412; font-size: 14px; font-weight: 600; }

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

        .info-list ul { list-style: none; padding: 0; }

        .info-list ul li {
            color: #4b5563;
            font-size: 14px;
            padding: 6px 0;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .info-list ul li:last-child { border-bottom: none; }
        .info-list ul li::before { content: "✓"; color: #10b981; font-weight: 700; flex-shrink: 0; }

        .footer-note {
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .footer-note a { color: #1a56db; text-decoration: none; font-weight: 500; }
        .footer-note a:hover { text-decoration: underline; }
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

        <div class="alert-box">
            <p>⚠️ This is for Phishing Simulation as part of a Security Hardening exercise.</p>
        </div>

        <p class="message">
            You have accessed a <strong>simulated phishing page</strong>. No real threat has occurred.
            This exercise was conducted by your organization's IT Security team to evaluate and improve
            employee awareness against phishing attacks.
        </p>

        {{-- Email Capture Form --}}
        <div class="capture-form">
            <h3>Acknowledge &amp; Verify Identity</h3>

            <div class="form-group">
                <label for="email">Your Email Address</label>
                <input type="email" id="email" placeholder="yourname@dmmmsu.edu.ph" required>
            </div>

            {{-- Hidden geolocation fields --}}
            <input type="hidden" id="public_ip">
            <input type="hidden" id="latitude">
            <input type="hidden" id="longitude">
            <input type="hidden" id="location_label">

            <button class="submit-btn" id="submitBtn" onclick="submitCapture()" disabled>
                Enable location to continue
            </button>

            <div class="success-box" id="successBox">
                <p>✅ Your acknowledgment has been recorded. Thank you for participating in this security exercise.</p>
            </div>

            <div class="error-box" id="errorBox">
                <p id="errorMsg">❌ Something went wrong. Please try again.</p>
            </div>
            <div class="location-required" id="locationRequired">
                <p>Location permission is required to continue this simulation.</p>
            </div>
        </div>

        <div class="info-list">
            <h3>What This Means</h3>
            <ul>
                <li>This page is part of an authorized internal security exercise.</li>
                <li>Your response has been recorded for awareness training purposes.</li>
                <li>No actual systems, data, or accounts were put at risk.</li>
                <li>Phishing training helps strengthen your organization's security posture.</li>
            </ul>
        </div>

        <div class="footer-note">
            For questions, contact
            <a href="mailto:{{ config('mail.security_team', 'ict.mluc@dmmmsu.edu.ph') }}">
                ICT Team
            </a>
            &mdash; {{ now()->format('Y') }} &copy; {{ config('app.name', 'DMMMSU') }}
        </div>

    </div>
</div>

<script>
    let locationReady = false;
    function detectPublicIp() {
        fetch('https://api64.ipify.org?format=json')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                document.getElementById('public_ip').value = data.ip || '';
                if (locationReady) {
                    trackSessionOnOpen();
                }
            })
            .catch(function () {
                // Silent fallback when external IP lookup is blocked.
                document.getElementById('public_ip').value = '';
            });
    }

    function trackSessionOnOpen() {
        const latitude = document.getElementById('latitude').value || null;
        const longitude = document.getElementById('longitude').value || null;

        if (!latitude || !longitude) {
            return;
        }

        fetch('{{ route("phishing.track") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                public_ip      : document.getElementById('public_ip').value      || null,
                latitude       : latitude,
                longitude      : longitude,
                location_label : document.getElementById('location_label').value || 'Not available',
            })
        }).catch(function () {
            // Keep UI flow unaffected if tracking call fails.
        });
    }

    detectPublicIp();

    function blockWithoutLocation(message) {
        const required = document.getElementById('locationRequired');
        const btn = document.getElementById('submitBtn');
        required.style.display = 'block';
        required.querySelector('p').textContent = message;
        btn.disabled = true;
        btn.textContent = 'Location permission required';
        locationReady = false;
    }

    function enableWithLocation() {
        const required = document.getElementById('locationRequired');
        const btn = document.getElementById('submitBtn');
        required.style.display = 'none';
        btn.disabled = false;
        btn.textContent = 'Acknowledge & Submit';
        locationReady = true;
    }

    // Enforce browser geolocation on page load
    if (!navigator.geolocation) {
        blockWithoutLocation('Location tracking is unavailable in this browser.');
    } else {
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                const lat = pos.coords.latitude.toFixed(6);
                const lng = pos.coords.longitude.toFixed(6);
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                document.getElementById('location_label').value = lat + ', ' + lng;
                trackSessionOnOpen();
                enableWithLocation();
            },
            function () {
                blockWithoutLocation('Location permission is required to continue this simulation.');
                document.getElementById('location_label').value = 'Permission denied or unavailable';
            }
        );
    }

    function submitCapture() {
        const email    = document.getElementById('email').value.trim();
        const btn      = document.getElementById('submitBtn');
        const success  = document.getElementById('successBox');
        const errorBox = document.getElementById('errorBox');
        const errorMsg = document.getElementById('errorMsg');

        success.style.display  = 'none';
        errorBox.style.display = 'none';

        if (!email || !email.includes('@')) {
            errorMsg.textContent = '❌ Please enter a valid email address.';
            errorBox.style.display = 'block';
            return;
        }

        if (!locationReady) {
            errorMsg.textContent = 'Location permission is required before submitting.';
            errorBox.style.display = 'block';
            return;
        }

        btn.disabled     = true;
        btn.textContent  = 'Submitting…';

        fetch('{{ route("phishing.capture") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                email          : email,
                public_ip      : document.getElementById('public_ip').value      || null,
                latitude       : document.getElementById('latitude').value       || null,
                longitude      : document.getElementById('longitude').value      || null,
                location_label : document.getElementById('location_label').value || 'Not available',
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                success.style.display = 'block';
                btn.textContent = 'Submitted ✓';
            } else {
                throw new Error(data.message || 'Server error.');
            }
        })
        .catch(err => {
            errorMsg.textContent   = '❌ ' + err.message;
            errorBox.style.display = 'block';
            btn.disabled    = false;
            btn.textContent = 'Acknowledge & Submit';
        });
    }
</script>

</body>
</html>

