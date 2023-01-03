<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project, Request $request)
    {
        $input = $request->validate([
            'body' => ['required']
        ]);

        return $project->addTask($input['body']);
    }
}
