<div class="card text-xs mt-5">
    @foreach ($project->activity as $activity)
    <div class="mb-3 mb-last-none">
        @include("projects.activity._{$activity->description}")
        <span class="text-gray-600">{{$activity->created_at->diffForHumans(null, true)}}</span>
    </div>
    @endforeach
</div>