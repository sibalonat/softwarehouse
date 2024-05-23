<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\DeleteProjectsWithoutDevelopersJob;
use App\Jobs\DeleteDevelopersThatHaveLongCreatedJob;
use App\Jobs\DeleteSalesForceThatHaveLongCreatedJob;

class RunPruneJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:prune-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // delete projects without developers
        DeleteProjectsWithoutDevelopersJob::dispatch();
        // delete developers that have long created job
        DeleteDevelopersThatHaveLongCreatedJob::dispatch();
        // delete salesforce that have long created job
        DeleteSalesForceThatHaveLongCreatedJob::dispatch();
    }
}
