@extends('layouts.app')

@section('content')

<div class="card max-w-xl mx-auto mt-12 p-10 flex flex-col items-center shadow-lg">
    <div class="text-center text-3xl font-bold text-gray-600">{{ __('Login') }}</div>

    <div class="mt-8 max-w-xs w-full">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                <div class="mt-1">
                    <input id="email" type="email" class="input @error('email') input--error @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <div class="input__error" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="mt-5">
                <label for="password" class="label">{{ __('Password') }}</label>

                <div class="mt-1">
                    <input id="password" type="password" class="input @error('password') input--error @enderror"
                        name="password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="mt-5">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="mt-8">
                <div class="flex items-baseline">
                    <button type="submit" class="button">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                    <a class="ml-3 text-gray-500 text-sm" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection