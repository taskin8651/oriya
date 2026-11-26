<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $authTitle }} · {{ trans('panel.site_title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <script src="{{ asset('js/auth.js') }}" defer></script>
</head>
<body class="auth-page">
    <main class="auth-shell">
        <aside class="auth-identity" aria-label="{{ trans('panel.site_title') }}">
            <div class="auth-brand">
                <span class="auth-brand-mark" aria-hidden="true"></span>
                {{ trans('panel.site_title') }}
            </div>

            <div class="auth-art" aria-hidden="true">
                <div class="auth-art-back"></div>
                <div class="auth-art-front">
                    <div class="auth-art-masthead"></div>
                    <div class="auth-art-image"></div>
                    <div class="auth-art-copy"></div>
                </div>
            </div>

            <a class="auth-site-link" href="{{ url('/') }}">{{ __('Visit website') }} <span aria-hidden="true">↗</span></a>
        </aside>

        <section class="auth-panel" aria-labelledby="auth-title">
            <div class="auth-panel-inner">
                <header class="auth-heading">
                    <h1 id="auth-title">{{ $authTitle }}</h1>
                </header>

                @foreach(array_filter([session('message'), session('status')]) as $message)
                    <p class="auth-notice" role="status">{{ $message }}</p>
                @endforeach

                @yield('content')
            </div>
        </section>
    </main>
</body>
</html>
