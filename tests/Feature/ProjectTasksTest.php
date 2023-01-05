<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_cannot_add_task()
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', Task::factory()->raw())->assertRedirect('/login');
    }

    /** @test */
    public function only_project_owner_can_add_a_task()
    {
        $this->be(User::factory()->create());

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', Task::factory()->raw(['project_id' => $project->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function only_project_owner_can_update_a_task()
    {
        $this->be(User::factory()->create());

        $task = Task::factory()->create();

        $this->patch($task->path(), [
            'body' => 'Change',
            'completed' => true
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'Change',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_project_can_be_updated()
    {
        $this->be(User::factory()->create());

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $task = Task::factory(['project_id' => $project->id])->create();

        $this->patch($task->path(), [
            'body' => 'Change',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Change',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_project_can_add_task()
    {
        $this->be(User::factory()->create());

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->post($project->path() . '/tasks', $task = Task::factory()->raw());

        $this->get($project->path())->assertSee($task['body']);
    }

    /** @test */
    public function a_project_requires_a_body()
    {
        $this->be(User::factory()->create());

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->post($project->path() . '/tasks', Task::factory()->raw(['body' => '']))
            ->assertSessionHasErrors('body');
    }
}
