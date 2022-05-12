<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required'
        ]);

        //dd($attributes);

        Project::create($attributes);

        return redirect('/projects');
    }

    public function show(Project $project)
    {
        return view('projects.show', [
            'project' => $project
        ]);
    }
}
