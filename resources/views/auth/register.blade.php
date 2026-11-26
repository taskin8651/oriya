@extends('layouts.auth-premium', ['authTitle' => __('Create account')])

@section('content')
    @if(Route::has('register'))
        <form class="auth-form" method="POST" action="{{ route('register') }}">
            @csrf

            <x-auth.field name="name" :label="__('Name')" :value="old('name')"
                maxlength="255" autocomplete="name" required autofocus />

            <x-auth.field name="email" :label="__('Email address')" type="email" :value="old('email')"
                maxlength="255" autocomplete="email" required />

            <x-auth.field name="password" :label="__('Password')" type="password" minlength="8"
                autocomplete="new-password" required />

            <x-auth.field name="password_confirmation" id="password-confirm" :label="__('Confirm password')"
                type="password" autocomplete="new-password" required />

            <button class="auth-submit" type="submit">{{ __('Create account') }}</button>
        </form>

        <p class="auth-switch">{{ __('Already have an account?') }} <a class="auth-link" href="{{ route('login') }}">{{ trans('global.login') }}</a></p>
    @else
        <p class="auth-notice">{{ __('Account registration is currently unavailable.') }}</p>
        <a class="auth-submit" href="{{ route('login') }}">{{ trans('global.login') }}</a>
    @endif
@endsection
