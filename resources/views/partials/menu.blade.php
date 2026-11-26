@php
    $currentRoute = request()->route()?->getName() ?? '';
    $activeListRoute = Str::startsWith($currentRoute, 'admin.')
        ? Str::beforeLast($currentRoute, '.') . '.index'
        : null;

    $sections = [
        ['cruds.userManagement.title', 'fas fa-users', 'user_management_access', [
            ['cruds.permission.title', 'permission_access', 'admin.permissions.index'],
            ['cruds.role.title', 'role_access', 'admin.roles.index'],
            ['cruds.user.title', 'user_access', 'admin.users.index'],
            ['cruds.auditLog.title', 'audit_log_access', 'admin.audit-logs.index'],
        ]],
        ['cruds.artical.title', 'far fa-file-alt', 'artical_access', [
            ['cruds.category.title', 'category_access', 'admin.categories.index'],
            ['cruds.tag.title', 'tag_access', 'admin.tags.index'],
            ['cruds.post.title', 'post_access', 'admin.posts.index'],
        ]],
        ['cruds.gallery.title', 'far fa-image', 'gallery_access', 'admin.galleries.index'],
        ['cruds.comment.title', 'far fa-comment-dots', 'comment_access', 'admin.comments.index'],
        ['cruds.websiteSetup.title', 'fas fa-cog', 'website_setup_access', [
            ['cruds.headerLogo.title', 'header_logo_access', 'admin.header-logos.index'],
            ['cruds.footerLogo.title', 'footer_logo_access', 'admin.footer-logos.index'],
            ['cruds.contactDetail.title', 'contact_detail_access', 'admin.contact-details.index'],
            ['cruds.contactUs.title', 'contact_us_access', 'admin.contact-uss.index'],
            ['cruds.newsletter.title', 'newsletter_access', 'admin.newsletters.index'],
            ['cruds.seo.title', 'seo_access', 'admin.seos.index'],
            ['cruds.crousel.title', 'crousel_access', 'admin.crousels.index'],
        ]],
        ['cruds.epaper.title', 'far fa-file', 'epaper_access', 'admin.epapers.index'],
        ['cruds.ad.title', 'far fa-window-maximize', 'ad_access', 'admin.ads.index'],
        ['cruds.eventsManagement.title', 'far fa-calendar-alt', 'events_management_access', [
            ['cruds.seatManagement.title', 'seat_management_access', 'admin.seat-managements.index'],
            ['cruds.venue.title', 'venue_access', 'admin.venues.index'],
            ['cruds.createEvent.title', 'create_event_access', 'admin.create-events.index'],
            ['cruds.bookinSeat.title', 'bookin_seat_access', 'admin.bookin-seats.index'],
        ]],
        ['cruds.breakingNews.title', 'fas fa-bolt', 'breaking_news_access', 'admin.breaking-newss.index'],
    ];
@endphp
<aside class="dashboard-sidebar" id="dashboard-sidebar">
    <a class="dashboard-brand" href="#">
        <i class="fas fa-globe" aria-hidden="true"></i>
        <span><strong>{{ trans('panel.site_title') }}</strong></span>
    </a>

    <nav class="dashboard-nav" aria-label="Administration">
        <a @class(['nav-row', 'nav-active' => request()->routeIs('admin.home')]) href="{{ route('admin.home') }}"
            @if(request()->routeIs('admin.home')) aria-current="page" @endif>
            <i class="fas fa-home" aria-hidden="true"></i><span>{{ trans('global.dashboard') }}</span>
        </a>

        @foreach($sections as [$label, $icon, $permission, $destination])
            @continue(Gate::denies($permission))
            @if(is_array($destination))
                @php
                    $groupOpen = in_array($activeListRoute, array_column($destination, 2), true);
                @endphp
                <details class="nav-group" @if($groupOpen) open @endif>
                    <summary @class(['nav-row', 'nav-parent-active' => $groupOpen])>
                        <i class="{{ $icon }}" aria-hidden="true"></i><span>{{ trans($label) }}</span>
                        <i class="fas fa-chevron-down nav-chevron" aria-hidden="true"></i>
                    </summary>
                    <div class="nav-children">
                        @foreach($destination as [$childLabel, $childPermission, $childRoute])
                            @can($childPermission)
                                <a href="{{ route($childRoute) }}"
                                    @if($activeListRoute === $childRoute) aria-current="{{ request()->routeIs($childRoute) ? 'page' : 'location' }}" @endif>{{ trans($childLabel) }}</a>
                            @endcan
                        @endforeach
                    </div>
                </details>
            @else
                <a @class(['nav-row', 'nav-active' => $activeListRoute === $destination]) href="{{ route($destination) }}"
                    @if($activeListRoute === $destination) aria-current="{{ request()->routeIs($destination) ? 'page' : 'location' }}" @endif>
                    <i class="{{ $icon }}" aria-hidden="true"></i><span>{{ trans($label) }}</span>
                </a>
            @endif
        @endforeach

        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')) && Route::has('profile.password.edit'))
            @can('profile_password_edit')
                <a @class(['nav-row', 'nav-active' => request()->routeIs('profile.password.edit')]) href="{{ route('profile.password.edit') }}"
                    @if(request()->routeIs('profile.password.edit')) aria-current="page" @endif>
                    <i class="fas fa-key" aria-hidden="true"></i><span>{{ trans('global.change_password') }}</span>
                </a>
            @endcan
        @endif
    </nav>
    <form class="dashboard-nav-footer" action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="nav-row" type="submit">
            <i class="fas fa-sign-out-alt" aria-hidden="true"></i><span>{{ trans('global.logout') }}</span>
        </button>
    </form>
</aside>
