<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('artical_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/categories*") ? "c-show" : "" }} {{ request()->is("admin/tags*") ? "c-show" : "" }} {{ request()->is("admin/posts*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.artical.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/categories") || request()->is("admin/categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.category.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('tag_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.tags.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tags") || request()->is("admin/tags/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.tag.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('post_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.posts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/posts") || request()->is("admin/posts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.post.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('gallery_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.galleries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/galleries") || request()->is("admin/galleries/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-images c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.gallery.title') }}
                </a>
            </li>
        @endcan
        @can('comment_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.comments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/comments") || request()->is("admin/comments/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.comment.title') }}
                </a>
            </li>
        @endcan
        @can('website_setup_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/header-logos*") ? "c-show" : "" }} {{ request()->is("admin/footer-logos*") ? "c-show" : "" }} {{ request()->is("admin/contact-details*") ? "c-show" : "" }} {{ request()->is("admin/contact-uss*") ? "c-show" : "" }} {{ request()->is("admin/newsletters*") ? "c-show" : "" }} {{ request()->is("admin/seos*") ? "c-show" : "" }} {{ request()->is("admin/crousels*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.websiteSetup.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('header_logo_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.header-logos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/header-logos") || request()->is("admin/header-logos/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-image c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.headerLogo.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('footer_logo_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.footer-logos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/footer-logos") || request()->is("admin/footer-logos/*") ? "c-active" : "" }}">
                                <i class="fa-fw far fa-file-image c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.footerLogo.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('contact_detail_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.contact-details.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contact-details") || request()->is("admin/contact-details/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.contactDetail.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('contact_us_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.contact-uss.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/contact-uss") || request()->is("admin/contact-uss/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-phone-square c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.contactUs.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('newsletter_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.newsletters.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/newsletters") || request()->is("admin/newsletters/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.newsletter.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('seo_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.seos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/seos") || request()->is("admin/seos/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.seo.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('crousel_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.crousels.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/crousels") || request()->is("admin/crousels/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.crousel.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('epaper_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.epapers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/epapers") || request()->is("admin/epapers/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.epaper.title') }}
                </a>
            </li>
        @endcan
        @can('ad_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.ads.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/ads") || request()->is("admin/ads/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.ad.title') }}
                </a>
            </li>
        @endcan
        @can('events_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/seat-managements*") ? "c-show" : "" }} {{ request()->is("admin/venues*") ? "c-show" : "" }} {{ request()->is("admin/create-events*") ? "c-show" : "" }} {{ request()->is("admin/bookin-seats*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.eventsManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('seat_management_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.seat-managements.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/seat-managements") || request()->is("admin/seat-managements/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.seatManagement.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('venue_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.venues.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/venues") || request()->is("admin/venues/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.venue.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('create_event_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.create-events.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/create-events") || request()->is("admin/create-events/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.createEvent.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('bookin_seat_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.bookin-seats.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/bookin-seats") || request()->is("admin/bookin-seats/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.bookinSeat.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('breaking_news_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.breaking-newss.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/breaking-newss") || request()->is("admin/breaking-newss/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.breakingNews.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>