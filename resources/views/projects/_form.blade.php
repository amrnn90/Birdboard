@php
    $project = $project ?? App\Project::make();
@endphp

<div>
    <label for="title" class="label">Title</label>

    <div class="mt-1">
        <input id="title" name="title" type="text" class="input @error('title') input--error @enderror"
            value="{{ old('title', $project->title) }}" required autofocus>

        @error('title')
        <div class="input__error" role="alert">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

<div class="mt-5">
    <label for="description" class="label">Description</label>

    <div class="mt-1">
        <textarea id="description" class="input @error('description') input--error @enderror"
            name="description">{{ old('description', $project->description)}}</textarea>

        @error('description')
        <span class="input__error" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="mt-8">
    <div class="flex items-baseline">
        <button type="submit" class="button">
            {{ $project->exists ? 'Update' : 'Create' }}
        </button>

        <a class="ml-3 text-gray-500 text-sm" href="/projects">Cancel</a>
    </div>
</div>