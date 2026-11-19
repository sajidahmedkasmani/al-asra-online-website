<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
        $middleware->appendToGroup('web', \App\Http\Middleware\CaptureMarketingAttribution::class);
        $middleware->redirectUsersTo(fn (Request $request) => $request->routeIs('login')
            ? route('admin.dashboard')
            : route('home'));
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('newsletter:dispatch-due')->everyMinute()->withoutOverlapping();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();