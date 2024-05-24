<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SalesPersonOnboardsTheProject;
use App\Jobs\CreateDeveloperWithRequirementJob;
use App\Jobs\CreateProjectsWithRequirementsJob;
use App\Jobs\CreateSalesPeopleWithRequirementJob;

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

        ds(auth()->user());

        while (now()->diffInSeconds($start) < 60) {

            CreateProjectsWithRequirementsJob::dispatch();
            CreateSalesPeopleWithRequirementJob::dispatch();
            CreateDeveloperWithRequirementJob::dispatch();

            SalesPersonOnboardsTheProject::dispatch();

            sleep(5);
        }
    }
}
