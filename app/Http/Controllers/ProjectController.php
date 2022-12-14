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
        Project::create([
            'title' => $request->title,
            'body' => $request->body
        ]);

        return redirect('/projects');
    }
}
