@extends('layouts.app')
@section('content')

<div class="card max-w-xl mx-auto mt-12 p-10 flex flex-col items-center shadow-lg">
    <div class="text-center text-3xl font-bold text-gray-600">Edit Project</div>

    <div class="mt-8 max-w-xs w-full">
        <form method="POST" action="{{ $project->path() }}">
            @csrf
            @method('PATCH')
            @include('projects._form')
        </form>
    </div>
</div>
@endsection