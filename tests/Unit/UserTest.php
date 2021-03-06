<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function a_user_has_projects()
    {
        $user = factory('App\User')->create();

        factory('App\Project', 2)->create(['owner_id' => $user->id]);

        $this->assertCount(2, $user->projects);
    }
}
