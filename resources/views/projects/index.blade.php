@extends('layouts.app')
@section('content')

<header class="py-3 mb-5">
    <div class="flex items-end justify-between">
        <h2 class="text-gray-600 text-sm">My Projects</h2>
        <a href="/projects/create" class="button" @click.prevent="$modal.show('create-project')">New Project</a>
    </div>
</header>

<div class="lg:flex w-full flex-wrap -mr-4">
    @forelse ($projects as $project)
    <div class="lg:w-1/3">
        <div class="mb-5 mr-4">
            @include('projects._card', ['project' => $project])
        </div>
    </div>
    @empty
    <div>No projects yet</div>
    @endforelse
</div>


<create-project-modal />


@endsection