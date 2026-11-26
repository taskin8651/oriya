<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard · NewsPortal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <script src="{{ asset('js/dashboard-navigation.js') }}" defer></script>
    <script src="{{ asset('js/admin-dashboard.js') }}" defer></script>
</head>
<body class="news-admin">
    @include('partials.menu')
    <button type="button" class="dashboard-backdrop" data-sidebar-close aria-label="Close navigation" hidden></button>

    <div class="dashboard-shell">
        @include('partials.dashboard-header')

        <main class="dashboard-main">
            <div class="dashboard-heading">
                <div>
                    <h1>Dashboard</h1>
                    <p>Welcome back! Here's what's happening with your news portal today.</p>
                </div>
                <details class="dashboard-dropdown dashboard-date">
                    <summary><i class="far fa-calendar-alt" aria-hidden="true"></i> {{ $rangeLabel }} <i class="fas fa-chevron-down" aria-hidden="true"></i></summary>
                    <div class="dropdown-panel">
                        @foreach($ranges as $key => $label)
                            <a href="{{ route('admin.home', array_filter(['range' => $key, 'q' => $search], fn ($value) => $value !== '')) }}"
                                @if((string) $key === $range) aria-current="true" @endif>{{ $label }}</a>
                        @endforeach
                    </div>
                </details>
            </div>

            @foreach(array_filter([session('status'), session('message')]) as $message)
                <p class="dashboard-flash" role="status">{{ $message }}</p>
            @endforeach

            <section class="metrics-grid" aria-label="News portal totals for the selected range">
                @foreach($metrics as $metric)
                    @php
                        $value = $metric['value'];
                        $previous = $metric['previous'];
                        $change = $value !== null && $previous > 0 ? round(100 * ($value - $previous) / $previous) : null;
                    @endphp
                    <article class="metric-card {{ $loop->first ? 'metric-featured' : '' }}">
                        <span class="metric-icon"><i class="{{ $metric['icon'] }}" aria-hidden="true"></i></span>
                        <div class="metric-data">
                            <h2>{{ $metric['label'] }}</h2>
                            <div class="metric-values">
                                <strong>{{ $value === null ? '—' : number_format($value) }}</strong>
                                @if($change !== null && $change != 0)
                                    <span class="metric-change {{ $change < 0 ? 'metric-fall' : '' }}" title="Compared with the previous period">
                                        <i class="fas {{ $change < 0 ? 'fa-arrow-down' : 'fa-arrow-up' }}" aria-hidden="true"></i>
                                        {{ $change > 0 ? '+' : '' }}{{ number_format($change) }}%
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>

            <div class="dashboard-grid">
                <section class="dashboard-card overview-card" aria-labelledby="overview-title">
                    <div class="card-heading overview-heading">
                        <h2 id="overview-title">News Activity Overview</h2>
                        @if($chart['series'])
                            <div class="chart-options" aria-label="Chart metric">
                                @foreach($chart['series'] as $label => $series)
                                    <button type="button" data-chart-series="{{ $label }}" aria-pressed="false"
                                        @if($label === 'Views') title="Stored views grouped by post creation date" @endif>{{ $label }}</button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="chart-stage">
                        <canvas id="dashboard-chart" aria-label="Daily activity for the selected date range" role="img"></canvas>
                        <span class="chart-tooltip" hidden></span>
                        <p class="chart-empty" hidden></p>
                    </div>
                    <script id="dashboard-chart-data" type="application/json">@json($chart)</script>
                </section>

                <section class="dashboard-card category-card" aria-labelledby="category-title">
                    <div class="card-heading"><h2 id="category-title">Popular Categories</h2></div>
                    @php
                        $colors = ['#ff292f', '#ff6877', '#ff9220', '#ffbd14', '#ab59f5', '#418ff9'];
                        $total = $categories->sum('count');
                        $startAngle = 0;
                        $segments = [];
                        foreach ($categories as $index => $category) {
                            $endAngle = $startAngle + 360 * $category['count'] / $total;
                            $segments[] = $colors[$index] . ' ' . $startAngle . 'deg ' . $endAngle . 'deg';
                            $startAngle = $endAngle;
                        }
                    @endphp
                    <div class="category-layout">
                        <div class="category-ring" style="--segments: {{ $segments ? 'conic-gradient(' . implode(', ', $segments) . ')' : '#292a31' }}" aria-hidden="true">
                            <div><strong>{{ number_format($total) }}</strong><small>News</small></div>
                        </div>
                        @if($total)
                            <ul class="category-legend">
                                @foreach($categories as $index => $category)
                                    <li>
                                        <span class="category-dot" style="--category-color: {{ $colors[$index] }}"></span>
                                        <span class="category-label" title="{{ $category['name'] }}">{{ $category['name'] }}</span>
                                        <strong>{{ round(100 * $category['count'] / $total) }}%</strong>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="muted">No category activity in this period.</p>
                        @endif
                    </div>
                </section>

                <section class="dashboard-card recent-card" aria-labelledby="recent-title">
                    <div class="card-heading">
                        <h2 id="recent-title">{{ $search === '' ? 'Recent News' : 'Matching News' }}</h2>
                        <div class="card-links">
                            @if($search !== '')
                                <a href="{{ route('admin.home', ['range' => $range]) }}">Clear search</a>
                            @endif
                            @can('post_access')
                                <a href="{{ route('admin.posts.index') }}">View All <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                            @endcan
                        </div>
                    </div>
                    <div class="table-scroll">
                        <table class="news-table">
                            <thead><tr><th scope="col">#</th><th scope="col">News Title</th><th scope="col">Category</th><th scope="col">Views</th><th scope="col">Status</th><th scope="col">Created</th><th scope="col"><span class="sr-only">Actions</span></th></tr></thead>
                            <tbody>
                                @forelse($recentNews as $post)
                                    @php
                                        $image = $post->image;
                                        $views = $recentViews[$post->id];
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="story-title">
                                                @if($image)
                                                    <img src="{{ $image->preview }}" alt="" width="60" height="42">
                                                @else
                                                    <span class="story-placeholder"><i class="far fa-image" aria-hidden="true"></i></span>
                                                @endif
                                                <span title="{{ $post->title }}">{{ $post->title ?: 'Untitled news' }}</span>
                                            </div>
                                        </td>
                                        <td><span class="category-chip category-chip-{{ ($post->category_id ?? 0) % 3 }}">{{ $post->category?->name ?? 'Uncategorized' }}</span></td>
                                        <td><span class="story-views"><i class="far fa-eye" aria-hidden="true"></i> {{ $views === null ? '—' : number_format($views) }}</span></td>
                                        <td><span class="status-chip {{ $post->status === 'published' ? 'status-published' : '' }}">{{ \App\Models\Post::STATUS_SELECT[$post->status] ?? 'Draft' }}</span></td>
                                        <td>{{ $post->created_at?->format('M j, Y') ?? '—' }}</td>
                                        <td>
                                            @can('post_show')
                                                <a class="row-action" href="{{ route('admin.posts.show', $post) }}" aria-label="View {{ $post->title }}"><i class="fas fa-ellipsis-h" aria-hidden="true"></i></a>
                                            @elsecan('post_edit')
                                                <a class="row-action" href="{{ route('admin.posts.edit', $post) }}" aria-label="Edit {{ $post->title }}"><i class="fas fa-ellipsis-h" aria-hidden="true"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="table-empty">{{ $search === '' ? 'No news to show in this period.' : 'No news matches your search in this period.' }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="dashboard-card actions-card" aria-labelledby="actions-title">
                    <div class="card-heading"><h2 id="actions-title">Quick Actions</h2></div>
                    @php
                        $actions = [
                            ['post_create', 'admin.posts.create', 'fas fa-plus', 'Add News'],
                            ['category_create', 'admin.categories.create', 'fas fa-layer-group', 'Add Category'],
                            ['user_create', 'admin.users.create', 'fas fa-user-plus', 'Add Author'],
                            ['gallery_create', 'admin.galleries.create', 'far fa-image', 'Upload Media'],
                        ];
                    @endphp
                    @canany(array_column($actions, 0))
                        <div class="quick-actions">
                            @foreach($actions as [$permission, $route, $icon, $label])
                                @can($permission)
                                    <a href="{{ route($route) }}" @class(['action-primary' => $loop->first])>
                                        <i class="{{ $icon }}" aria-hidden="true"></i>
                                        <span>{{ $label }}</span>
                                    </a>
                                @endcan
                            @endforeach
                        </div>
                    @else
                        <p class="muted">No quick actions available.</p>
                    @endcanany
                </section>
            </div>
        </main>
    </div>
</body>
</html>
