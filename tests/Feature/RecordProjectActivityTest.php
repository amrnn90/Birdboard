<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class RecordProjectActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created_project', $project->activity->first()->description);
        $this->assertEquals(null, $project->activity->first()->diff);

    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectFactory::create(['title' => 'initial title']);
        $project->update(['title' => 'changed title']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated_project', $project->activity->last()->description);

        $expectedChanges = [
            'before' => ['title' => 'initial title'],
            'after' => ['title' => 'changed title']
        ];

        $this->assertEquals($expectedChanges, $project->activity->last()->diff);
    }

    /** @test */
    public function creating_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
    }

    /** @test */
    public function test_completing_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks->last()->complete();

        $this->assertCount(3, $project->activity);

        $this->assertEquals('completed_task', $project->activity->last()->description);
    }

    /** @test */
    public function incompleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $task = $project->tasks->last();

        $task->complete();

        $this->assertCount(3, $project->activity);

        $task->incomplete();

        $project->refresh();

        $this->assertCount(4, $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }

    /** @test */
    public function recorded_activity_may_have_a_subject()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $activity = $project->activity->last();

        $this->assertInstanceOf(Task::class, $activity->subject);
    }

    /** @test */
    public function recorded_activity_has_a_user()
    {
        $user = $this->login();
        $invitedUser = factory('App\User')->create();
        $project = ProjectFactory::ownedBy($user)->withTasks(1)->create();

        $this->assertEquals($user->id, $project->activity->last()->user_id);

        $project->invite($invitedUser);
        
        $this->login($invitedUser);
        $project->update(['title' => 'changed title']);
        $project->refresh();

        $this->assertEquals($invitedUser->id, $project->activity->last()->user_id);

    }
}
