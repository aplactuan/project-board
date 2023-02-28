<?php

namespace Tests\Unit;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_an_activity_when_project_is_created()
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activities);
        $this->assertEquals('created', $project->activities->first()->description);
    }

    public function test_it_generates_an_activity_when_project_is_updated()
    {
        $project = Project::factory()->create();

        $project->update([
            'title' => 'Change the title'
        ]);

        $this->assertEquals('updated', $project->activities->last()->description);
        $this->assertCount(2, $project->activities);
    }
}
