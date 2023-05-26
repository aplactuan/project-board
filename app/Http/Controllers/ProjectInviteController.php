<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\InviteProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectInviteController extends Controller
{
    public function __invoke(Project $project, InviteProjectRequest $request)
    {
        $user = User::where('email', $request->get('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
