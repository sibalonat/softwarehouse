<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SalesPersonOnboardsTheProject;
use App\Jobs\CreateDeveloperWithRequirementJob;
use App\Jobs\CreateProjectsWithRequirementsJob;
use App\Jobs\DeleteProjectsWithoutDevelopersJob;
use App\Jobs\CreateSalesPeopleWithRequirementJob;
use App\Jobs\DeleteDevelopersThatHaveLongCreatedJob;

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

        while (now()->diffInSeconds($start) < 60) {

            CreateProjectsWithRequirementsJob::dispatch();
            CreateSalesPeopleWithRequirementJob::dispatch();
            CreateDeveloperWithRequirementJob::dispatch();

            SalesPersonOnboardsTheProject::dispatch();

            sleep(5);
        }
    }
}
