<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class HomeController
{
    public function index(Request $request)
    {
        $ranges = ['month' => 'This month', '7' => 'Last 7 days', '30' => 'Last 30 days', '90' => 'Last 90 days'];
        $range = $request->query('range', 'month');
        $range = is_string($range) && isset($ranges[$range]) ? $range : 'month';
        $search = $request->query('q');
        $search = is_string($search) ? Str::limit(trim($search), 100, '') : '';
        $today = CarbonImmutable::today();
        $start = $range === 'month' ? $today->startOfMonth() : $today->subDays((int) $range - 1);
        $end = $today->addDay();
        $previousStart = $start->subDays($start->diffInDays($end));

        $canSeePosts = Gate::allows('post_access');
        $canSeeComments = Gate::allows('comment_access');
        $posts = Post::where('created_at', '>=', $start)->where('created_at', '<', $end);
        $previousPosts = Post::where('created_at', '>=', $previousStart)->where('created_at', '<', $start);
        $comments = Comment::where('created_at', '>=', $start)->where('created_at', '<', $end);

        $newsByDay = $canSeePosts ? $this->countsByDay(clone $posts) : collect();
        $commentsByDay = $canSeeComments ? $this->countsByDay(clone $comments) : collect();
        $viewsByDay = collect();
        $previousViews = null;

        if ($canSeePosts) {
            // The legacy view field also holds video links and embeds.
            $records = Post::where('created_at', '>=', $previousStart)->where('created_at', '<', $end)
                ->whereNotNull('view')->toBase()->select('created_at', 'view')->cursor();

            foreach ($records as $record) {
                $views = self::storedViews($record->view);
                if ($views === null) {
                    continue;
                }

                $day = substr($record->created_at, 0, 10);
                if ($day < $start->toDateString()) {
                    $previousViews = ($previousViews ?? 0) + $views;
                } else {
                    $viewsByDay[$day] = $viewsByDay->get($day, 0) + $views;
                }
            }
        }

        $metrics = [
            ['label' => 'Total News', 'icon' => 'far fa-file-alt', 'value' => $canSeePosts ? $newsByDay->sum() : null,
                'previous' => $canSeePosts ? $previousPosts->count() : null],
            ['label' => 'Total Views', 'icon' => 'far fa-eye', 'value' => $viewsByDay->isEmpty() ? null : $viewsByDay->sum(),
                'previous' => $previousViews],
            ['label' => 'Total Authors', 'icon' => 'fas fa-user-friends',
                'value' => $canSeePosts ? (clone $posts)->whereHas('author')->distinct()->count('author_id') : null,
                'previous' => $canSeePosts ? (clone $previousPosts)->whereHas('author')->distinct()->count('author_id') : null],
            ['label' => 'Total Comments', 'icon' => 'far fa-comment-dots', 'value' => $canSeeComments ? $commentsByDay->sum() : null,
                'previous' => $canSeeComments ? Comment::where('created_at', '>=', $previousStart)->where('created_at', '<', $start)->count() : null],
        ];

        $chart = ['labels' => [], 'series' => []];
        $dailySeries = array_filter([
            'Views' => $canSeePosts ? $viewsByDay : null,
            'News' => $canSeePosts ? $newsByDay : null,
            'Comments' => $canSeeComments ? $commentsByDay : null,
        ], fn ($series) => $series !== null);

        foreach ($dailySeries as $name => $series) {
            $chart['series'][$name] = $name === 'Views' && $series->isEmpty() ? null : [];
        }

        for ($date = $start; $date < $end; $date = $date->addDay()) {
            $chart['labels'][] = $date->format('M j');
            foreach ($dailySeries as $name => $series) {
                if ($chart['series'][$name] !== null) {
                    $chart['series'][$name][] = (int) $series->get($date->toDateString(), 0);
                }
            }
        }

        $categories = collect();
        $recentNews = collect();

        if ($canSeePosts) {
            $categories = $this->popularCategories(clone $posts);
            $recentNews = $posts->with(['category', 'media'])
                ->when($search !== '', function ($query) use ($search) {
                    $term = '%' . $search . '%';
                    $query->where(function ($query) use ($term) {
                        $query->where('title', 'like', $term)
                            ->orWhereHas('category', fn ($category) => $category->where('name', 'like', $term))
                            ->orWhereHas('author', fn ($author) => $author->where('name', 'like', $term));
                    });
                })
                ->latest()->orderByDesc('id')->limit(3)->get();
        }

        return view('home', [
            'ranges' => $ranges,
            'range' => $range,
            'search' => $search,
            'rangeLabel' => $start->format($start->year === $today->year ? 'M j' : 'M j, Y') . ' – ' . $today->format('M j, Y'),
            'metrics' => $metrics,
            'chart' => $chart,
            'categories' => $categories,
            'recentNews' => $recentNews,
            'recentViews' => $recentNews->mapWithKeys(fn (Post $post) => [$post->id => self::storedViews($post->view)]),
            'pendingComments' => $canSeeComments ? Comment::where('status', 'pending')->count() : 0,
        ]);
    }

    private function countsByDay($query)
    {
        return $query->selectRaw('DATE(created_at) AS day, COUNT(*) AS total')
            ->groupByRaw('DATE(created_at)')->pluck('total', 'day');
    }

    private function popularCategories($posts)
    {
        $counts = $posts->selectRaw('category_id, COUNT(*) AS total')->groupBy('category_id')
            ->orderByDesc('total')->orderBy('category_id')->pluck('total', 'category_id');
        $names = Category::whereIn('id', $counts->keys()->filter()->all())->pluck('name', 'id');
        $top = $counts->filter(fn ($count, $id) => $names->has($id))->take(5);
        $categories = $top->map(fn ($count, $id) => ['name' => $names[$id], 'count' => (int) $count])->values();
        $other = $counts->sum() - $top->sum();

        if ($other > 0) {
            $categories->push(['name' => 'Other', 'count' => $other]);
        }

        return $categories;
    }

    private static function storedViews(?string $value): ?int
    {
        $value = trim($value ?? '');

        return ctype_digit($value) ? (int) $value : null;
    }
}
