<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', ['projects' => $projects]);
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate(['title' => 'required', 'description' => 'required']);

        $request->user()->projects()->create($attributes);

        return redirect('/projects');
    }
}
