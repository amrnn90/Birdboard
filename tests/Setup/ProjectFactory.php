<?php

namespace Tests\Setup;

class ProjectFactory
{ 
    protected $ownedBy = null;
    protected $tasksCount = 0;

    public function ownedBy($user)
    {
        $this->ownedBy = $user;

        return $this;
    }

    public function withTasks($count)
    {
        $this->tasksCount = $count;

        return $this;
    }

    public function create($attributes = [])
    {
        if ($this->ownedBy) {
            $attributes['owner_id'] = $this->ownedBy->id;
        }

        $project = factory('App\Project')->create($attributes);

        factory('App\Task', $this->tasksCount)->create(['project_id' => $project->id]);

        return $project;
    }
}
