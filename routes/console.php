<?php

use App\Console\Commands\RunJobsCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\CreateDeveloperWithRequirementJob;
use App\Jobs\CreateProjectsWithRequirementsJob;
use App\Jobs\CreateSalesPeopleWithRequirementJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command(RunJobsCommand::class)->everyMinute();

