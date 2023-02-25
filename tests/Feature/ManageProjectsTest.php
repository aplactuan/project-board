<?php

namespace Tests\Feature;

use App\Models\Project;
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
        //$this->withoutExceptionHandling();
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'notes' => 'General notes'
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $project = Project::where($attributes)->first();

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
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
