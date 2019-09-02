<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_invite_anyone_to_a_project()
    {
        $user = factory('App\User')->create();
        $project = ProjectFactory::create();
        $this->post($project->path() . "/invitations", ['email' => $user->email])
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_cannot_invite_others_to_a_project_they_dont_own()
    {
        $this->login();
        $memberOfProject = factory('App\User')->create();
        $anotherUser = factory('App\User')->create();
        $project = ProjectFactory::create();

        $project->invite($memberOfProject);

        $this->post($project->path() . "/invitations", ['email' => $anotherUser->email])
            ->assertStatus(403);
        $this->login($memberOfProject);
        $this->post($project->path() . "/invitations", ['email' => $anotherUser->email])
            ->assertStatus(403);
        $this->assertCount(1, $project->members);
    }

    /** @test */
    public function only_users_of_birdboard_can_be_invited_by_email()
    {
        $project = ProjectFactory::ownedBy($this->login())->create();
        $this->post($project->path() . "/invitations", ['email' => 'invalid@invalid.com'])
            ->assertSessionHasErrors(['email'], null, 'invitations');
    }

    /** @test */
    public function a_user_can_invite_another_user_to_their_project()
    {
        $user = $this->login();
        $anotherUser = factory('App\User')->create();

        $project = ProjectFactory::ownedBy($user)->create();
        $this->post($project->path() . "/invitations", ['email' => $anotherUser->email])
            ->assertRedirect($project->path());
        $this->assertEquals($anotherUser->id, $project->members->first()->id);
        
        $this->login($anotherUser);
        $task = factory('App\Task')->raw();
        $this->post($project->path() . '/tasks', $task);
        $this->assertCount(1, $project->tasks);
    }
}
