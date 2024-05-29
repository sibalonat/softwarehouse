<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\Project\AssignDeveloperToProject;
use App\Models\Developer;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::query()
        ->whereNotNull('sales_people_id')
        ->whereNull('developer_id')
        ->with('developer')
        ->paginate(5)
        ->withQueryString();
        return inertia('Production/ProductionProjectScreen', [
            'projects' => $projects,
            'developers' => Developer::whereHired(true)->whereDoesntHave('project')->get()->toLabelValueArray('name', 'id')
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(AssignDeveloperToProject $request, Project $project)
    {
        $request->validated();
        $data['developer_id'] = $request->developer_id;
        $project->update($data);
        Developer::find($data['developer_id'])->update(['is_busy' => true]);
    }
}
