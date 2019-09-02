<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    protected $validationRules = ['body' => 'required'];

    public function store(Project $project)
    {
        $this->authorize('update', $project);

        $this->validateRequest($this->validationRules);
         
        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Task $task) 
    {
        $this->authorize('update', $task->project);

        $data = $this->validateRequest($this->validationRules);

        $task->update($data);

        if (request('completed')) {
            $task->complete();
        } else {
            $task->incomplete();
        }

        return redirect($task->project->path());
    }
    
}
