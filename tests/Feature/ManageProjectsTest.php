<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function guests_cannot_manage_projects()
    {   
        $project = factory("App\Models\Project")->create();   

        $this->get('/projects')->assertRedirect('login');

        $this->get('/project/create')->assertRedirect('login');
        
        $this->post('/projects', $project->toArray())->assertRedirect('login');

        $this->get($project->path())->assertRedirect('login');
        
        $this->get($project->path() . '/edit')->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->authenticate();

        $this->get('/project/create')->assertStatus(200);

        $attributes = factory(Project::class)->raw();

        $this->followingRedirects()->post('/projects', $attributes)
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function tasks_can_be_included_as_part_a_new_project()
    {
        $this->authenticate();

        $attributes = factory(Project::class)->raw();

        $attributes['tasks'] = [
            ['body' => 'Task 1'],
            ['body' => 'Task 2']
        ];

        $this->post('/projects', $attributes);

        $this->assertCount(2, Project::first()->tasks);
    }

    /** @test */
    public function include_only_task_with_body()
    {
        $this->authenticate();

        $attributes = factory(Project::class)->raw();

        $attributes['tasks'] = [
            ['body' => 'Task 1'],
            ['body' => ''],
            ['body' => 'Task 2']
        ];

        $this->post('/projects', $attributes);

        $this->assertCount(2, Project::first()->tasks);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->authenticate())->create();

        $this->patch($project->path(), $attributes = [
            'title' => 'Changed',
            'description' => 'Changed',
            'notes' => 'Changed'
        ])->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_project_general_notes()
    {
        $project = ProjectFactory::ownedBy($this->authenticate())->create();

        $this->patch($project->path(), $attributes = [
            'notes' => 'Changed'
        ])->assertRedirect($project->path());
        
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_view_their_projects()
    {
        $project = ProjectFactory::ownedBy($this->authenticate())->create();
    
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
       $project = tap(ProjectFactory::create())->invite($this->authenticate());

       $this->get('/projects')
       ->assertSee($project->title);
    }

    /** @test */
    public function guests_cannot_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())
        ->assertRedirect('/login');

        $user = $this->authenticate();

        $this->delete($project->path())
        ->assertStatus(403);

        $project->invite($user);

        $this->delete($project->path())
        ->assertStatus(403);
    }
    
    /** @test */
    public function a_user_can_delete_a_project()
    {
        $project = ProjectFactory::ownedBy($this->authenticate())->create();

        $this->delete($project->path())
        ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }


    /** @test */
    public function a_user_cannot_view_the_projects_of_others()
    {
        $this->authenticate();

        $project = factory("App\Models\Project")->create();
    
        $this->get($project->path())
            ->assertStatus(403);
    }

     /** @test */
    public function a_user_cannot_update_the_projects_of_others()
    {
        $this->authenticate();

        $project = factory("App\Models\Project")->create();
    
        $this->patch($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->authenticate();

        $attributes = factory("App\Models\Project")->raw(['title' => '']);
 
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->authenticate();        

        $attributes = factory("App\Models\Project")->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    
}
