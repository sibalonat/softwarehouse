<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\RunJobsCommand;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\SalesPersonOnboardsTheProject;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command(RunJobsCommand::class)->everyMinute();
