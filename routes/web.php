<?php

// ---------------------------------------------------------------
// Phishing Simulation Routes
// Add these lines inside your routes/web.php file
// ---------------------------------------------------------------

use App\Http\Controllers\PhishingSimulationController;

// The link you embed in your phishing simulation email
// e.g. https://yourdomain.com/security-notice
Route::get('/', [PhishingSimulationController::class, 'show'])
    ->name('phishing.show');

// The POST endpoint the form submits to
Route::post('/security-notice/capture', [PhishingSimulationController::class, 'capture'])
    ->name('phishing.capture');