<?php

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{
    protected $taskCount = 0;
    protected User $user;

    public function ownedBy(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function withTasks(int $count)
    {
        $this->taskCount = $count;
        return $this;
    }

    public function create()
    {
        $project = Project::factory()
            ->create([
                'owner_id' => $this->user ?? User::factory()->create()
            ]);

        if ($this->taskCount > 0) {
            Task::factory()
                ->count($this->taskCount)
                ->for($project)
                ->create();
        }

        return $project;
    }
}
