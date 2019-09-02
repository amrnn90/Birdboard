<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Support\Facades\DB;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path() . '/edit')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
        $this->patch($project->path(), ['title' => 'changed'])->assertRedirect('/login');
        $this->delete($project->path())->assertRedirect('/login');
    }

    /** @test */
    public function a_user_cannot_delete_a_project_they_dont_own()
    {
        $user = $this->login();
        $owner = factory('App\User')->create();

        $project = ProjectFactory::ownedBy($owner)->create();

        $this->delete($project->path())->assertStatus(403);

        $project->invite($user);

        $this->delete($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_cannot_update_a_project_he_doesnt_own()
    {
        $this->login();

        $project = factory('App\Project')->create();

        $this->patch($project->path(), ['title' => 'changed'])
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_view_all_projects_he_has_access_to(Type $var = null)
    {
        $user = $this->login();
        $ownedProject = ProjectFactory::ownedBy($user)->create();
        $invitedProject = factory('App\Project')->create();

        $this->assertEquals([$ownedProject->id], $user->accessibleProjects()->pluck('id')->toArray());
        
        $invitedProject->invite($user);

        $this->assertEquals([$ownedProject->id, $invitedProject->id], $user->accessibleProjects()->pluck('id')->toArray());
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $project = ProjectFactory::ownedBy($this->login())->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_cannot_view_a_project_they_dont_own()
    {
        $this->login();

        $project = factory('App\Project')->create();

        $this->get($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->login();

        $attributes = factory('App\Project')->raw();

        $this->get('/projects/create')->assertStatus(200);

        $this->post('/projects', $attributes)->assertRedirect('/projects/1');

        $this->assertCount(1, Project::all());

        $this->get('/projects/1')->assertSee($attributes['title']);
        $this->get('/projects/1')->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_create_a_project_with_tasks()
    {
        $this->login();

        $attributes = factory('App\Project')->raw();
        $attributes['tasks'] = [['body' => 'task 1'], ['body' => 'task 2']];

        $this->post('/projects', $attributes);

        $this->assertCount(1, Project::all());

        $this->assertCount(2, Task::all());
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::ownedBy($this->login())->create();

        $attributes = [
            'title' => 'changed title',
            'description' => 'changed description',
            'notes' => 'changed notes'
        ];


        $this->patch($project->path(), $attributes)->assertRedirect('/projects/1');
        $this->assertDatabaseHas('projects', $attributes);

        $attributes = [
            'title' => 'changed title again',
            'description' => 'changed description again',
        ];

        $this->patch($project->path(), $attributes)->assertRedirect('/projects/1');
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_delete_a_project()
    {
        $project = ProjectFactory::ownedBy($this->login())->create();

        $this->delete($project->path())->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->login();

        $attributes = factory('App\Project', ['title' => ''])->raw();

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->login();

        $attributes = factory('App\Project', ['description' => ''])->raw();

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors(['description']);
    }
}
