<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    protected $validationRules = [
        'title' => 'required',
        'description' => 'required',
        'notes' => ''
    ];

    public function index()
    {
        $projects = auth()->user()->accessibleProjects()->get();
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function store()
    {
        $data = $this->validateRequest($this->validationRules);

        $project = auth()->user()->projects()->create($data);

        if ($tasks = request('tasks')) {
            $project->addTasks($tasks);
        }

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project->update($this->validateRequest($this->validationRules));

        return redirect($project->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }
}
