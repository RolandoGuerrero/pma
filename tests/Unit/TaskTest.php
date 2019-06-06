<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_task_belongs_to_a_project()
    {
        $task = factory('App\Models\Task')->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function is_has_a_path()
    {
        $task = factory('App\Models\Task')->create();
    
        $this->assertEquals('/project/' . $task->project->id . '/task/' . $task->id, $task->path());
    }
}
