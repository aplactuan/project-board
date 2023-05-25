<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function it_can_invite_other_user_to_update_the_project()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($owner = $this->signIn())->create();

        $john = User::factory()->create();

        $this->post($project->path() . '/invite', [
            'email' => $john->email
        ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($john));
    }

    /** @test */
    public function invited_user_can_add_a_task()
    {
        $project = Project::factory()->create();

        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);

        $this->post(route('projects.task.add', $project), $task = Task::factory()->raw([
            'project_id' => $project->id
        ]));

        $this->assertDatabaseHas('tasks', $task);
    }
}
