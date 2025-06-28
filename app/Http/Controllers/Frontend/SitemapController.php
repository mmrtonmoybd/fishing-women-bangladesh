<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;
use App\Models\Page;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $posts = Post::where('status', true)->latest()->get();
  
        return response()->view('sitemap', [
            'posts' => $posts,
            'pages' => Page::get(),
        ])->header('Content-Type', 'text/xml');
    }
}
