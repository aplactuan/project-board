<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project, Request $request)
    {
        $this->authorize('update', $project);

        $input = $request->validate([
            'body' => ['required']
        ]);

        return $project->addTask($input['body']);
    }

    public function update(Project $project, Task $task, Request $request)
    {
        $this->authorize('update', $task->project);

        $input = $request->validate([
            'body' => ['required'],
        ]);

        $task->update([
            'body' => $input['body'],
            'completed' => $request->has('completed')
        ]);

        return redirect($project->path());
    }
}