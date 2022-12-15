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

    public function store(Request $request)
    {
        $attributes = $request->validate(['title' => 'required', 'description' => 'required']);

        Project::create($attributes);

        return redirect('/projects');
    }
}
