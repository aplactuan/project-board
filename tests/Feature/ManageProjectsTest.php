<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_cannot_manage_projects()
    {
        $this->get('/projects')->assertRedirect('/login');

        $this->get('/projects/create')->assertRedirect('/login');

        $this->post('/projects', Project::factory()->raw())->assertRedirect('/login');

        $project = Project::factory()->create();
        $this->get($project->path())->assertRedirect('/login');
        $this->get($project->path() . '/edit')->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $user = $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $response = $this->followingRedirects()
            ->post('/projects', $attributes = Project::factory()->raw([
            'owner_id' => $user->id
            ]));

        $response->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function it_can_add_project_with_tasks()
    {
        $user = $this->signIn();

        $attributes = array_merge(
            Project::factory()->raw(['owner_id' => $user->id]),
            ['tasks' => [
                'body' => 'First Task'
            ]]
        );

        $response = $this->followingRedirects()
            ->post('/projects', $attributes);

        //$response->assertSee('First Task');

        $this->assertDatabaseHas('tasks', [
            'body' => 'First Task'
        ]);
    }

    /** @test */
    public function guest_and_not_project_owner_cannot_delete_a_project()
    {
        $project = Project::factory()->create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())
            ->assertStatus(403);

        $project->invite($invitedUser = User::factory()->create());

        $this->signIn($invitedUser);

        $this->delete($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function user_can_delete_a_project()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $this->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id
        ]);
    }

    /** @test */
    public function a_user_can_update_an_owned_project()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $this->get($project->path() . '/edit')
            ->assertSee($project->title)
            ->assertSee($project->description);

        $this->patch($project->path(), [
            'title' => 'Title Change',
            'description' => 'Description change'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', [
            'title' => 'Title Change',
            'description' => 'Description change'
        ]);
    }

    /** @test */
    public function a_user_can_update_project_notes_only()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $this->patch($project->path(), [
            'notes' => 'Note change',
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', [
            'notes' => 'Note change',
        ]);
    }

    /** @test */
    public function a_user_can_clear_the_notes_of_the_project()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create([
            'notes' => 'Project notes'
        ]);

        $this->patch($project->path(), [
            'notes' => '',
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', [
            'notes' => null,
        ]);
    }

    /** @test */
    public function a_user_can_view_an_owned_project()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_can_view_owned_project_and_invited_project()
    {
        $john = $this->signIn();

        ProjectFactory::ownedBy($john)->create();

        $sally = User::factory()->create();

        $project = ProjectFactory::ownedBy($sally)->create();

        $project->invite($john);

        $this->get(route('projects.projects.index'))
            ->assertSee($project->title);
    }

    /** @test  */
    public function a_user_cannot_update_other_project()
    {
        $user = $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path() . '/edit')->assertStatus(403);

        $this->patch($project->path(),[
            'notes' => 'Change'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('projects', ['notes' => 'Change']);
    }

    /** @test  */
    public function a_user_cannot_view_other_project()
    {
        $user = $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_title()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors();
    }

    /** @test */
    public function a_project_requires_body()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors();
    }
}
