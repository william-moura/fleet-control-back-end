<?php

use App\Jobs\SendNotificationDue;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:notification-vehicle-fine-expire')->dailyAt('10:00');
Schedule::job(new SendNotificationDue())->everyMinute();