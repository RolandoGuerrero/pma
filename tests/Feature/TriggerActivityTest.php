<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function creating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
    
        tap($project->activity->last(), function($activity) {
            $this->assertEquals('created_project', $activity->description); 

            $this->assertNull($activity->changes);
        });
    }

    /** @test */
    public function updating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $original_title = $project->title;
        
        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity); 

        tap($project->activity->last(), function($activity) use($original_title){
            $this->assertEquals('updated_project', $activity->description); 

            $expected = [
                'before' => ['title' => $original_title],
                'after' => ['title' => 'Changed']
            ];

            $this->assertEquals($expected, $activity->changes);
        });

    }

    /** @test */
    public function creating_new_task_records_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask('Project task');

        $this->assertCount(2, $project->activity); 

        tap($project->activity->last(), function($activity){
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Project task', $activity->subject->body);
        });

    }

    /** @test */
    public function completing_a_task_records_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(), [
            'body' => 'updated',
            'completed' => true
        ]);
        
      
        $this->assertCount(3, $project->activity); 

        tap($project->activity->last(), function($activity){
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /** @test */
    public function incompleting_a_task_records_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(), [
            'body' => 'updated',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity); 

        $this->patch($project->tasks[0]->path(), [
            'body' => 'updated',
            'completed' => false
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity); 

        tap($project->activity->last(), function($activity){
            $this->assertEquals('incompleted_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

    }

    /** @test */
    public function deleting_a_task_records_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity); 

        $this->assertEquals('deleted_task', $project->activity->last()->description); 
    }
}
