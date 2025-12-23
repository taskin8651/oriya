<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Ad;
use App\Models\Category;

class PostController extends Controller
{
   public function index($slug)
{
    // CURRENT category
    $category = Category::where('slug', $slug)->firstOrFail();
     // Get posts of this category
        $posts = Post::with('media')
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->latest()
            ->take(20) // You can increase
            ->get();

    // All categories sorted (for ordering)
    $allCategories = Category::orderBy('id')->get();
    $currentIndex = $allCategories->search(function ($cat) use ($category) {
        return $cat->id === $category->id;
    });

  // CENTER: Current category posts with pagination (5 per page)
    $centerPosts = Post::with('media')
        ->where('category_id', $category->id)
        ->where('status', 'published')
        ->latest()
        ->paginate(5); // 5 posts per page


   // LEFT: Next 2 categories (sirf jinke posts hain)
$leftCategories = $allCategories
    ->slice($currentIndex + 1, 2)
    ->filter(function ($cat) {
        return $cat->posts->where('status', 'published')->count() > 0;
    })
    ->take(2);

// Posts of those categories
$leftPosts = Post::with('media')
    ->whereIn('category_id', $leftCategories->pluck('id'))
    ->where('status', 'published')
    ->latest()
    ->get();



    // RIGHT: Previous categories
    $rightCategories = $allCategories->slice(0, $currentIndex);

    $rightPosts = Post::with('media')
        ->whereIn('category_id', $rightCategories->pluck('id'))
        ->where('status', 'published')
        ->latest()
        ->take(20)
        ->get();

         $sidebarAd = Ad::where('type', 'sidebar')
    ->where('status', 'active')
    ->first();


    return view('custom.post', compact(
        'category',
        'centerPosts',
        'leftPosts',
        'rightPosts',
        'leftCategories',
        'rightCategories',
        'posts',
        'sidebarAd'
    ));
}



   public function postDetails($slug)
{
    $post = Post::with(['author', 'tags', 'category', 'media'])
                ->where('slug', $slug)
                ->firstOrFail();

    // Increase view count
    // $post->increment('view');

    // Related posts
    $related = Post::where('category_id', $post->category_id)
                ->where('id', '!=', $post->id)
                ->latest()
                ->take(5)
                ->get();

    $sidebarAd = Ad::where('type', 'sidebar')
    ->where('status', 'active')
    ->first();

    return view('custom.post-detail', compact('post', 'related','sidebarAd'));
}


public function liveSearch(Request $request)
{
    $q = $request->q;

    $posts = \App\Models\Post::where('title', 'LIKE', "%$q%")
        ->orWhere('content', 'LIKE', "%$q%")
        ->select('title', 'slug')
        ->limit(10)
        ->get();

    return response()->json($posts);
}


}
