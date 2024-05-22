<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\SalesPeople;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\ProjectComplexityAttribute;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Enums\SalesPersonExperienceAttribute;

class SalesPersonOnboardsTheProject implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         // Get all salespeople
         $salespeople = SalesPeople::whereHired(true)->whereIsBusy(false)->get();

         // Loop through each salesperson
         foreach ($salespeople as $salesperson) {
             // Get the salesperson's experience level
             $experience = $salesperson->experience;

             // Determine the maximum project complexity the salesperson can handle
             $maxComplexity = $this->getMaxComplexity($experience);

            // Get the first project that the salesperson can handle and doesn't have a salesperson assigned
            $project = Project::where('complexity', '<=', $maxComplexity)
                ->whereNull('sales_people_id')
                ->first();

            // If a project was found, assign it to the salesperson
            if ($project) {
                $project->sales_people_id = $salesperson->id;
                $project->save();
            }
        }
    }

    /**
     * Determine the maximum project complexity a salesperson can handle based on their experience.
     *
     * @param  string  $experience
     * @return int
     */
    protected function getMaxComplexity($experience)
    {
        switch ($experience) {
            case SalesPersonExperienceAttribute::Beginner:
                return ProjectComplexityAttribute::Low->value;
            case SalesPersonExperienceAttribute::Intermediate:
                return ProjectComplexityAttribute::Medium->value;
            case SalesPersonExperienceAttribute::Advanced:
                return ProjectComplexityAttribute::High->value;
            default:
                return ProjectComplexityAttribute::Low->value;
        }
    }
}
