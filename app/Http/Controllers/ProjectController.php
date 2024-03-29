<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->manageProjects();

        return view('projects.index', ['projects' => $projects]);
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        $project = new Project();
        return view('projects.create', compact('project'));
    }

    public function store(ProjectRequest $request)
    {
        $project = $request->user()->projects()->create($request->except('tasks'));
        if ($tasks = $request->tasks) {
            foreach ($tasks as $task) {
                $project->addTask($task);
            }
        }

        return redirect($project->path());
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect(route('projects.projects.index'));
    }
}
