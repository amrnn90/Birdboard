<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;

class ProjectInvitationsController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('manage', $project);
        $this->validateWithBag('invitations', request(), [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Invited person must be a user of Birdboard'
        ]);


        $userToInvite = User::where('email', request('email'))->firstOrFail();
        
        $project->invite($userToInvite);

        return redirect($project->path());
    }
}
