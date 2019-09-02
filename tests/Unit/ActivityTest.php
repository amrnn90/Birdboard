<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->login())->create();

        $this->assertInstanceOf(User::class, $project->activity->first()->user);
        $this->assertTrue(auth()->user()->is($project->activity->first()->user));
    }
}
