<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;
    
    protected $guarded = [];

    public function path()
    {
        return '/projects/' . $this->id;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(['body' => $body]);
    }

    public function addTasks($tasks)
    {
        $tasks = collect($tasks)->filter(function($task) {
            return $task['body'];
        });
        return $this->tasks()->createMany($tasks->toArray());
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_member')->withTimestamps();
    }

    public function invite($user)
    {
        $this->members()->attach($user);
    }

}
