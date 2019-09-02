@extends('layouts.app')
@section('content')

<div class="card max-w-xl mx-auto mt-12 p-10 flex flex-col items-center shadow-lg">
    <div class="text-center text-3xl font-bold text-gray-600">Create a new project</div>

    <div class="mt-8 max-w-xs w-full">
        <form method="POST" action="/projects">
            @csrf
            @include('projects._form')
        </form>
    </div>
</div>
@endsection