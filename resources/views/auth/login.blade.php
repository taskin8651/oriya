@extends('layouts.auth-premium', ['authTitle' => trans('global.login')])

@section('content')
    <form class="auth-form" method="POST" action="{{ route('login') }}">
        @csrf

        <x-auth.field name="email" :label="trans('global.login_email')" :value="old('email')"
            autocomplete="email" inputmode="email" required autofocus />

        <x-auth.field name="password" :label="trans('global.login_password')" type="password"
            autocomplete="current-password" required />

        <div class="auth-form-options">
            <label class="auth-remember" for="remember">
                <input id="remember" name="remember" type="checkbox" @checked(old('remember'))>
                <span>{{ trans('global.remember_me') }}</span>
            </label>

            @if(Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">{{ trans('global.forgot_password') }}</a>
            @endif
        </div>

        <button class="auth-submit" type="submit">{{ trans('global.login') }}</button>
    </form>

    @if(Route::has('register'))
        <p class="auth-switch">{{ __('Need an account?') }} <a class="auth-link" href="{{ route('register') }}">{{ __('Register') }}</a></p>
    @endif
@endsection
