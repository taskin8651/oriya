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
        // Category find by slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Get posts of this category
        $posts = Post::with('media')
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->latest()
            ->take(20) // You can increase
            ->get();

        return view('custom.post', compact('category', 'posts'));
    }


   public function postDetails($slug)
{
    $post = Post::with(['author', 'tags', 'category', 'media'])
                ->where('slug', $slug)
                ->firstOrFail();

    // Increase view count
    $post->increment('view');

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


}
