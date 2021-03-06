<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function it_can_add_a_task()
    {
        $project = factory('App\Project')->create();

        $task = $project->addTask('Test Task');
        
        $this->assertTrue($project->tasks->contains($task));
    }

    /** @test */
    public function it_has_members()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf(Collection::class, $project->members);
    }

    /** @test */
    public function it_can_invite_a_user()
    {
        $project = factory('App\Project')->create();
        $invitedUser = factory('App\User')->create();

        $project->invite($invitedUser);

        $this->assertEquals($invitedUser->id, $project->members->first()->id);
    }
}
