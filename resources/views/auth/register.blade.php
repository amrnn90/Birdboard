@extends('layouts.app')

@section('content')

<div class="card max-w-xl mx-auto mt-12 p-10 flex flex-col items-center shadow-lg">
    <div class="text-center text-3xl font-bold text-gray-700">{{ __('Register') }}</div>

    <div class="mt-8 max-w-sm w-full">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="sm:flex">
                <div class="sm:mr-4">
                    <label for="name" class="label">{{ __('Name') }}</label>
    
                    <div class="mt-1">
                        <input id="name" type="text" class="input @error('name') input--error @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus>
    
                        @error('name')
                        <span class="input__error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
    
                <div class="mt-5 sm:mt-0">
                    <label for="email" class="label">{{ __('E-Mail Address') }}</label>
    
                    <div class="mt-1">
                        <input id="email" type="email" class="input @error('email') input--error @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email">
    
                        @error('email')
                        <span class="input__error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <label for="password" class="label">{{ __('Password') }}</label>

                <div class="mt-1">
                    <input id="password" type="password" class="input @error('password') input--error @enderror"
                        name="password" required autocomplete="new-password">

                    @error('password')
                    <span class="input__error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="mt-5">
                <label for="password-confirm" class="label">{{ __('Confirm Password') }}</label>

                <div class="mt-1">
                    <input id="password-confirm" type="password" class="input" name="password_confirmation" required
                        autocomplete="new-password">
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="button">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection