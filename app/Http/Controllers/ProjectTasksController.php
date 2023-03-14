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

        $project->addTask($input['body']);

        return redirect($project->path());
    }

    public function update(Project $project, Task $task, Request $request)
    {
        $this->authorize('update', $task->project);

        $input = $request->validate([
            'body' => ['required'],
        ]);

        $task->update([
            'body' => $input['body'],
        ]);

        if ($request->has('completed')) {
            $method = $request->completed ? 'complete' : 'incomplete';

            $task->$method();
        }

        return redirect($project->path());
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return redirect($project->path());
    }
}
