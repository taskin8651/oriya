<header class="dashboard-header">
    <button type="button" class="icon-button menu-button" data-sidebar-toggle aria-controls="dashboard-sidebar" aria-label="Toggle navigation">
        <i class="fas fa-bars" aria-hidden="true"></i>
    </button>

    @isset($adminPageTitle)
        <nav class="admin-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('admin.home') }}">Dashboard</a>
            @if(isset($adminRecord['listUrl']))
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                <a class="breadcrumb-parent" href="{{ $adminRecord['listUrl'] }}">{{ $adminRecord['listLabel'] }}</a>
            @endif
            <i class="fas fa-chevron-right" aria-hidden="true"></i>
            <span aria-current="page">{{ $adminRecord['breadcrumb'] ?? $adminPageTitle }}</span>
        </nav>
    @elseif(request()->routeIs('admin.home') && Gate::allows('post_access'))
        <form class="dashboard-search" action="{{ route('admin.home') }}" method="GET" role="search">
            <input type="hidden" name="range" value="{{ $range }}">
            <input type="search" name="q" value="{{ $search }}" maxlength="100" placeholder="Search news, categories, or authors..." aria-label="Search news, categories, or authors">
            <button type="submit" class="icon-button" aria-label="Search"><i class="fas fa-search" aria-hidden="true"></i></button>
        </form>
    @endisset

    <div class="header-tools">
        @if(isset($pendingComments) && Gate::allows('comment_access'))
            <details class="dashboard-dropdown notifications">
                <summary class="icon-button" aria-label="Comment notifications">
                    <i class="far fa-bell" aria-hidden="true"></i>
                    @if($pendingComments > 0)<span class="notification-dot"></span>@endif
                </summary>
                <div class="dropdown-panel">
                    <strong>Comments</strong>
                    <p>{{ $pendingComments === 0 ? 'No pending comments' : number_format($pendingComments) . ' pending ' . Str::plural('comment', $pendingComments) }}</p>
                    <a href="{{ route('admin.comments.index') }}">Manage comments</a>
                </div>
            </details>
        @elseif(count(config('panel.available_languages', [])) > 1)
            <details class="dashboard-dropdown admin-language">
                <summary aria-label="Choose language">{{ strtoupper(app()->getLocale()) }}</summary>
                <div class="dropdown-panel">
                    @foreach(config('panel.available_languages') as $locale => $language)
                        <a href="{{ request()->fullUrlWithQuery(['change_language' => $locale]) }}">{{ $language }}</a>
                    @endforeach
                </div>
            </details>
        @endif
        @php
            $account = auth()->user();
            $profile = $account->profile;
        @endphp
        <details class="dashboard-dropdown profile-menu">
            <summary aria-label="Account menu">
                @if($profile)
                    <img class="profile-avatar" src="{{ $profile->thumbnail }}" alt="">
                @else
                    <span class="profile-avatar" aria-hidden="true">{{ Str::upper(Str::substr($account->name ?? 'A', 0, 1)) }}</span>
                @endif
                <span class="profile-name">
                    <strong>{{ $account->name }}</strong>
                    <small>{{ $account->roles->first()?->title ?? 'Account' }}</small>
                </span>
                <i class="fas fa-chevron-down" aria-hidden="true"></i>
            </summary>
            <div class="dropdown-panel">
                @if(Route::has('profile.password.edit'))
                    @can('profile_password_edit')
                        <a href="{{ route('profile.password.edit') }}">{{ trans('global.change_password') }}</a>
                    @endcan
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">{{ trans('global.logout') }}</button>
                </form>
            </div>
        </details>
    </div>
</header>
