<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A project has path test
     *
     * @return void
     */
    public function test_a_project_has_path()
    {
        $project = Project::factory()->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    public function test_a_project_belongs_to_an_owner()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    public function test_a_project_can_add_a_task()
    {
        $project = Project::factory()->create();

        $task = $project->addTask('Task Test');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }

    public function test_it_can_invite_a_user()
    {
        $project = Project::factory()->create();

        $project->invite($user = User::factory()->create());

        $this->assertTrue($project->members->contains($user));
    }

    public function test_it_has_manage_projects()
    {
        $john = User::factory()->create();

        ProjectFactory::ownedBy($john)->create();

        $this->assertCount(1, $john->manageProjects());

        $sally = User::factory()->create();
        $brad = User::factory()->create();

        $project = tap(ProjectFactory::ownedBy($sally)->create())->invite($brad);
        //this should still be one because john is still not invitesd
        $this->assertCount(1, $john->manageProjects());

        $project->invite($john);
        //this will be 2 now since john is invited by sally
        $this->assertCount(2, $john->manageProjects());
    }
}
