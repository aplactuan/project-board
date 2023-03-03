<?php

namespace Tests\Unit;

use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_records_activity_when_project_is_created()
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activities);
        $this->assertEquals('created', $project->activities->first()->description);
    }

    public function test_it_records_activity_when_project_is_updated()
    {
        $project = Project::factory()->create();

        $project->update([
            'title' => 'Change the title'
        ]);

        $this->assertEquals('updated', $project->activities->last()->description);
        $this->assertCount(2, $project->activities);
    }

    public function test_it_records_activity_when_project_task_is_created()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $project->addTask('Test Task');

        $this->assertEquals('task created', $project->activities->last()->description);
        $this->assertCount(2, $project->activities);
    }

    public function test_it_records_activity_when_project_is_completed()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $task = $project->addTask('Test Task');

        $task->complete();

        $this->assertEquals('task completed', $project->activities->last()->description);
        $this->assertCount(3, $project->activities);
    }


}
