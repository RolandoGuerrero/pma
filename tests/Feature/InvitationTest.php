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
    public function a_project_owner_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
    
        $user = factory(User::class)->create();

        $this->actingAs($project->owner)
        ->post($project->path() . '/invitations',[
            'email' => $user->email
        ])
        ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($user));
    }

    /** @test */
    public function non_owner_may_not_invite_users()
    {
        $project = ProjectFactory::create();

        $user = factory(User::class)->create();

        $assertInvitationForbidden = function() use($project, $user){
            $this->actingAs($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);
        };
        
        $assertInvitationForbidden();

        $project->invite($user);

        $assertInvitationForbidden();
    }

    /** @test */
    public function the_email_address_must_be_associated_whit_a_valid_pma_account()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
        ->post($project->path() . '/invitations',[
            'email' => 'test@mail.com'
        ])
        ->assertSessionHasErrors([
            'email' => 'The user you are inviting must have a pma account.'
        ], null, 'invitations');

    }

    /** @test */
    public function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();
    
        $project->invite($new_user = factory(User::class)->create());

        $this->authenticate($new_user);

        $this->post(action('ProjectsTasksController@store', $project), $task = ['body' => 'Foo Task']);

        $this->assertDatabaseHas('tasks',$task);
    }
}
