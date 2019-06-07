<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
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
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->authenticate();

        $this->get('/project/create')->assertStatus(200);
          
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ]; 

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->authenticate();

        $this->withoutExceptionHandling();

        $project = factory("App\Models\Project")->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(), [
            'notes' => 'Changed'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'Changed']);
    }

    /** @test */
    public function a_user_can_view_their_projects()
    {
        $this->authenticate();

        $this->withoutExceptionHandling();

        $project = factory("App\Models\Project")->create(['owner_id' => auth()->id()]);
    
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
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
