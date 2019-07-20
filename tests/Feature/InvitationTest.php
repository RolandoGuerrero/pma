<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_project_can_invite_a_user()
    {
        $project = ProjectFactory::create();
    
        $project->invite($new_user = factory(User::class)->create());

        $this->authenticate($new_user);

        $this->post(action('ProjectsTasksController@store', $project), $task = ['body' => 'Foo Task']);

        $this->assertDatabaseHas('tasks',$task);
    }
}
