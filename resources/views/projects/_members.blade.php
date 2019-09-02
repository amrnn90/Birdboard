<div class="flex items-center">
        <img src="{{ $project->owner->gravatar }}" alt="{{ $project->owner->name }}"
            class="rounded-full w-12 h-12 border-2 border-white shadow mr-2" 
            title="{{ $project->owner->name }}">

        @foreach ($project->members as $member)
        <img src="{{ $member->gravatar }}" alt="{{ $member->name }}" class="rounded-full w-8 h-8 ml-2" title="{{ $member->name }}">
        @endforeach
    </div>