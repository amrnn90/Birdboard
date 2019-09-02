<div class="card mt-5">
    <h3 class="font-normal text-gray-800 text-xl py-2 -ml-5 mb-4 pl-5 border-l-4 border-blue-300">Invite Members</h3>

    <form action="{{ $project->path() . '/invitations' }}" method="POST" class="">
        @csrf
        <input type="text" class="input" name="email" type="email" placeholder="Email of user to invite" required>

        @foreach($errors->invitations->all() as $error)
        <div class="input__error">{{$error}}</div>
        @endforeach
        <button type="submit" class="button mt-3">Invite</button>
    </form>
</div>