<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_the_project()
    {

        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks')
            ->assertRedirect('login');
    }
    
    /** @test */
    public function a_project_can_have_tasks()
    {
        $project = ProjectFactory::ownedBy($this->authenticate())->create();    
        
        $this->post($project->path() . '/tasks', [
            'body' => 'Test Task'
        ]);

        $this->get($project->path())
            ->assertSee('Test Task');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = ProjectFactory::ownedBy($this->authenticate())
            ->withTasks(1)
            ->create();    
       
        $this->patch($project->tasks[0]->path(),[
            'body' => 'Changed'
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'Changed'
        ]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        $project = ProjectFactory::ownedBy($this->authenticate())
            ->withTasks(1)
            ->create();    
       
        $this->patch($project->tasks[0]->path(),[
            'body' => 'Changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'Changed',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_incompleted()
    {
        $project = ProjectFactory::ownedBy($this->authenticate())
            ->withTasks(1)
            ->create();    
       
        $this->patch($project->tasks[0]->path(),[
            'body' => 'Changed',
            'completed' => true
        ]);

        $this->patch($project->tasks[0]->path(),[
            'body' => 'Changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'Changed',
            'completed' => false
        ]);
    }


    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->authenticate();

        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks', [
                'body' => 'Test task'
            ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_a_task()
    {
        $this->authenticate();

        $project = ProjectFactory::withTasks(1)->create(); 

        $this->patch($project->tasks[0]->path() , [
                'body' => 'Updated'
            ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Updated']);
    }


    /** @test */
    public function a_task_requires_a_body()
    {
        $project = ProjectFactory::ownedBy($this->authenticate())->create();     

        $attributes = factory("App\Models\Task")->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)
        ->assertSessionHasErrors('body');
    }
}
