<div class="card h-48 flex flex-col justify-between">
    <div>
        <h3 class="font-normal text-gray-800 text-xl mb-2 py-2 -ml-5 pl-5 border-l-4 border-blue-300">
            @if($cardLinkProject ?? true)
                <a href="{{ $project->path() }}">{{ $project->title }}</a>
            @else
                {{ $project->title }}
            @endif
        </h3>
        <div class="text-gray-600 text-sm">{{ str_limit($project->description, 100) }}</div>
    </div>
    @can('manage', $project)
        <form action="{{ $project->path() }}" method="POST" class="ml-auto">
            @csrf
            @method('DELETE')

            <button type="submit" class="button py-1 px-3 bg-transparent border border-red-500 text-red-500 hover:bg-red-500 hover:text-red-100">Delete</button>
        </form>
    @endcan
</div>