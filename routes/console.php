<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule release of expired seat locks every minute
Schedule::command('app:release-expired-seat-locks')
    ->everyMinute()
    ->description('Release expired seat locks every minute')
    ->withoutOverlapping();
