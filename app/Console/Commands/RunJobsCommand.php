<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CreateDeveloperWithRequirementJob;
use App\Jobs\CreateProjectsWithRequirementsJob;
use App\Jobs\CreateSalesPeopleWithRequirementJob;
use App\Jobs\SalesPersonOnboardsTheProject;

class RunJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run jobs every five seconds';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = now();

        ds('Starting jobs');

        while (now()->diffInSeconds($start) < 60) {
            ds('Running jobs every five seconds');
            CreateProjectsWithRequirementsJob::dispatch();
            CreateSalesPeopleWithRequirementJob::dispatch();
            CreateDeveloperWithRequirementJob::dispatch();

            sleep(5);
        }
    }
}
