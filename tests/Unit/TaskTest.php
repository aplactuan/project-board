<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_project()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    public function test_it_has_a_path()
    {
        $task = Task::factory()->create();

        $this->assertEquals($task->project->path() . '/tasks/' . $task->id, $task->path());
    }

    public function test_it_can_complete_a_task()
    {
        $task = Task::factory()->create();

        $task->complete();

        $this->assertTrue($task->completed);
    }


}
