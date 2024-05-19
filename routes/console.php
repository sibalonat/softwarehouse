<?php

use App\Jobs\CreateProjectsWithRequirementsJob;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

$user = request()->user();

if ($user) {
    # code...
    Schedule::job(new CreateProjectsWithRequirementsJob(request()->user()->game()))
    ->everyMinute()
    ->when(function () {
        $user = request()->user()->game();
        return $user;
    });
}

