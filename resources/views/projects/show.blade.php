@extends('layouts.app')
@section('content')

<header class="py-3 mb-5 max-w-5xl mx-auto">
    <div class="flex items-baseline justify-between">
        <p class="text-gray-600 text-sm">
            <a href="/projects" class="text-gray-500 hover:text-gray-600">My Projects</a> / {{ $project->title }}
        </p>


        {{-- <img src="{{ $project->owner->gravatar }}" alt="{{ $project->owner->name }}" class="rounded-full w-12
        h-12 border-2 border-white shadow mr-2">

        @foreach ($project->members as $member)
        <img src="{{ $member->gravatar }}" alt="{{ $member->name }}" class="rounded-full w-8 h-8 ml-2">
        @endforeach --}}
        <a href="{{ $project->path() . '/edit' }}" class="button ml-10">Edit Project</a>
    </div>
</header>

<div class="lg:flex w-full flex-wrap max-w-5xl mx-auto">
    <div class="lg:w-3/4 ">
        <div class="lg:pr-4 mb-8 mb-6">
            <h2 class="text-gray-600 text-sm uppercase  mb-3">Tasks</h2>
            @foreach ($project->tasks as $task)
            <form action="{{ $task->path() }}" method="POST">
                @csrf
                @method('PATCH')

                @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
                @endforeach

                <div class="flex justify-between items-center card mb-3 py-3">
                    <input class="w-full mr-8 {{ $task->completed ? 'text-gray-500':'' }}" value="{{ $task->body }}"
                        name="body" id="body">
                    <input type="checkbox" value="1" {{ $task->completed ? 'checked' : ''}} name="completed"
                        id="completed" onchange="this.form.submit()">
                </div>
            </form>
            @endforeach
            <form action="{{ $project->path() . '/tasks' }}" method="POST">
                @csrf
                <input type="text" class="card mb-3 w-full" placeholder="Add a new task" name="body" id="body">
            </form>
        </div>

        <div class="lg:pr-4">
            <h2 class="text-gray-600 text-sm mb-3 uppercase">General Notes</h2>
            <form action="{{ $project->path() }}" method="POST" class="relative">
                @csrf
                @method('PATCH')
                <div class="pb-16 card w-full">
                    <textarea class="w-full resize-none" style="min-height: 150px" name="notes" id="notes">{{ $project->notes }}</textarea>
                </div>

                <button
                 type="submit"
                 class="absolute button mt-2 px-4 py-1 bg-white border-2 border-blue-400 text-gray-700 text-blue-600"
                 style="bottom: 18px; left: 18px">
                    Save Notes
                </button>
            </form>
        </div>

    </div>
    <div class="lg:w-1/4 lg:mt-0 mt-16">
        <div class="flex">
            <div class="lg:ml-6">
                @include('projects._members')

                <div class="mt-3">
                    @include('projects._card', ['project' => $project, 'cardLinkProject' => false])
                </div>

                @include('projects._activities')

                @can('manage', $project)
                @include('projects._invite')
                @endcan

            </div>

        </div>
    </div>
</div>


@endsection