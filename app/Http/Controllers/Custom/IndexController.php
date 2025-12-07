<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Ad;
use App\Models\Gallery;
use App\Models\Crousel;

class IndexController extends Controller
{
    public function index()
    {
        // Odisha category find
        $odishaCategory = Category::where('slug', 'local-news')->get();

        // If category mil jaye to posts fetch karo
        $odishaPosts = [];
        if ($odishaCategory) {
            $odishaPosts = Post::where('category_id', $odishaCategory->id)
                ->where('status', 'published')
                ->latest()
                ->take(10)
                ->get();
        }

        $sidebarAd = Ad::where('type', 'sidebar')
    ->where('status', 'active')
    ->first();

    $latestPosts = Post::where('status', 'published')
    ->latest()
    ->take(5)
    ->get();

    $latest12 = Post::where('status', 'published')
    ->latest()
    ->take(12)
    ->get();

    // ⭐ YouTube Videos
    $youtubeVideos = Gallery::where('title', 'youtube')
        ->latest()
        ->take(5)
        ->get();

// सभी categories लाओ
    $categories = Category::with(['posts' => function ($q) {
        $q->where('status', 'published')
          ->latest()
          ->take(3);   // हर category में 3 पोस्ट दिखाओ
    }])
    ->orderBy('name')
    ->get();
      $crousels = Crousel::all();
        
        return view('custom.index', compact('odishaPosts', 'sidebarAd', 'latestPosts', 'latest12', 'youtubeVideos','categories','crousels'));
    }
}
