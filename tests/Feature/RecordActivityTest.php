<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecordActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function project_is_created()
    {
        $this->signIn();

        $this->post('/projects', $attributes = Project::factory()->raw());

        $project = Project::where('title', $attributes['title'])->first();

        tap($project->activities->last(), function ($activity) {
            $this->assertEquals('created', $activity->description);
            $this->assertNull($activity->changes);
        });
        $this->assertCount(1, $project->activities);
    }

    /** @test  */
    public function project_is_updated()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();
        $oldTitle = $project->title;

        $this->patch($project->path(), [
            'title' => 'Change the title'
        ]);

        tap($project->activities->last(), function ($activity) use ($oldTitle) {
            $this->assertEquals('updated', $activity->description);

            $expected = [
                'before' => ['title' => $oldTitle],
                'after' => ['title' => 'Change the title']
            ];

            $this->assertEquals($expected, $activity->changes);
        });

        $this->assertCount(2, $project->activities);
    }

    /** @test */
    public function project_task_is_created()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $this->post($project->path() . '/tasks', Task::factory()->raw([
            'project_id' => $project->id
        ]));

        tap($project->activities->last(), function ($activity) {
            $this->assertEquals('task-created', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

        $this->assertCount(2, $project->activities);
    }

    /** @test  */
    public function project_task_is_completed()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $task = $project->addTask('Test Task');

        $this->patch($task->path(), [
            'body' => $task->body,
            'completed' => true
        ]);

        tap($project->fresh()->activities->last(), function ($activity) {
            $this->assertEquals('task-completed', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

        $this->assertCount(3, $project->activities);
    }

    /** @test */
    public function project_task_is_uncompleted()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $task = $project->addTask('Test Task');

        $this->patch($task->path(), [
            'body' => $task->body,
            'completed' => true
        ]);

        $this->assertCount(3, $project->activities);

        $this->patch($task->path(), [
            'body' => $task->body,
            'completed' => false
        ]);

        tap($project->fresh()->activities->last(), function ($activity) {
            $this->assertEquals('task-uncompleted', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

        $this->assertCount(4, $project->fresh()->activities);
    }

    /** @test */
    public function project_task_is_deleted()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $task = $project->addTask('Test Task');

        $this->delete($task->path());

        $project->refresh();


        $this->assertEquals('task-deleted', $project->activities->last()->description);
        $this->assertCount(3, $project->activities);
    }
}
