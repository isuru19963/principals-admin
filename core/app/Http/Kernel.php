<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
         \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\LanguageMiddleware::class,
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        'admin' => \App\Http\Middleware\RedirectIfNotAdmin::class,
        'admin.guest' => \App\Http\Middleware\RedirectIfAdmin::class,

        'doctor' => \App\Http\Middleware\RedirectIfNotDoctor::class,
        'doctor.guest' => \App\Http\Middleware\RedirectIfDoctor::class,

        'assistant' => \App\Http\Middleware\RedirectIfNotAssistant::class,
        'assistant.guest' => \App\Http\Middleware\RedirectIfAssistant::class,

        'staff' => \App\Http\Middleware\RedirectIfNotStaff::class,
        'staff.guest' => \App\Http\Middleware\RedirectIfStaff::class,

        'patient' => \App\Http\Middleware\RedirectIfNotPatient::class,
        'patient.guest' => \App\Http\Middleware\RedirectIfPatient::class,

        'regStatus' => \App\Http\Middleware\AllowRegistration::class,
        'checkStatus' => \App\Http\Middleware\CheckStatus::class,

        'checkDoctorStatus' => \App\Http\Middleware\checkDoctorStatus::class,
        'checkAssistantStatus' => \App\Http\Middleware\checkAssistantStatus::class,
        'checkStaffStatus' => \App\Http\Middleware\checkStaffStatus::class,
        'checkPatientStatus' => \App\Http\Middleware\checkPatientStatus::class,

        'demo' => \App\Http\Middleware\Demo::class,
    ];
}
