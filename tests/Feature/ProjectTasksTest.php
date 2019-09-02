<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTasks extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = factory('App\Project')->create();
        $attributes = factory('App\Task')->raw();

        $this->post($project->path() . '/tasks', $attributes)
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_cannot_add_tasks_to_a_project_he_doesnt_own()
    {
        $this->login();
        $project = factory('App\Project')->create();
        $attributes = factory('App\Task')->raw();

        $this->post($project->path() . '/tasks', $attributes)
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => $attributes['body']]);
    }

    /** @test */
    public function a_user_cannot_update_tasks_of_a_project_he_doesnt_own()
    {
        $this->login();

        $task = factory('App\Task')->create();

        $this->patch($task->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $project = ProjectFactory::ownedBy($this->login())->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test Task']);

        $this->get($project->path())->assertSee('Test Task');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = ProjectFactory::withTasks(1)
            ->ownedBy($this->login())
            ->create();

        $task = $project->tasks->first();

        $this->patch($task->path(), ['body' => 'changed'])
            ->assertRedirect($project->path());

        $this->get($project->path())->assertSee('changed');

        $this->patch($task->path(), ['body' => 'changed', 'completed' => '1'])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('tasks', ['body' => 'changed', 'completed' => true]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        $project = ProjectFactory::withTasks(1)
        ->ownedBy($this->login())
        ->create();

        $task = $project->tasks->first();

        $this->patch($task->path(), ['body' => $task->body, 'completed' => true]);

        $this->assertDatabaseHas('tasks', ['completed' => true]);
    }

    /** @test */
    public function a_task_can_be_marked_as_incomplete()
    {
        $project = ProjectFactory::withTasks(1)
        ->ownedBy($this->login())
        ->create();

        $task = $project->tasks->first();

        $task->complete();

        $this->patch($task->path(), ['body' => $task->body]);

        $this->assertDatabaseHas('tasks', ['completed' => false]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->withExceptionHandling();
        $project = ProjectFactory::ownedBy($this->login())->create();

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors(['body']);
    }
}
