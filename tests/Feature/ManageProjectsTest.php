<?php

namespace Tests\Feature;

use Tests\TestCase;
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
            'description' => $this->faker->paragraph
        ]; 

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
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
