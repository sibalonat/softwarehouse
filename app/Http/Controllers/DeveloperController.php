<?php

namespace App\Http\Controllers;

use App\Http\Requests\Developers\AssignProjectToDeveloper;
use App\Http\Requests\Project\AssignDeveloperToProject;
use App\Models\Project;
use App\Models\Developer;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::query()
        ->whereNotNull('sales_people_id')
        ->whereNull('developer_id')
        ->get()
        ->toLabelValueArray('name', 'id');
        return inertia('Production/ProductionDeveloperScreen', [
            'developers' => Developer::with('project')->whereHired(true)->paginate(5)->withQueryString(),
            'projects' => $projects
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssignDeveloperToProject $request, Developer $developer)
    {
        $request->validated();
        $project = Project::find($request->project_id);
        $data['project_id'] = $request->project_id;
        $project->update($data);
        $developer->update(['is_busy' => true]);
    }

}
