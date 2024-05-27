<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Project;
use App\Models\SalesPeople;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $salesforce = SalesPeople::whereHired(true)->count();
        $developers = Developer::whereHired(true)->count();
        $projects = Project::whereNotNull(['sales_people_id', 'developer_id'])->count();
        return inertia('Dashboard', [
            'salesforce' => $salesforce,
            'developers' => $developers,
            'projects' => $projects
        ]);
    }
}
