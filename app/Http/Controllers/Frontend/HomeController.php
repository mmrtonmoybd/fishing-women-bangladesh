<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'posts' => Post::where('status', true)->orderByDesc('id')->paginate(12),
            'title' => getSettingValue('seo.title'),
            'slider' => Slider::where('status', true)->orderBy('position', 'asc')->get(),
        ]);
    }

    public function postShow($id)
    {
        // dd($id);
        $post = Post::findOrFail($id);

        return view('home.single', [
            'post' => $post,
            'title' => $post->title.' - Post,',
        ]);
    }

    public function pageShow($id)
    {
        $page = Page::findOrFail($id);

        return view('home.page', [
            'page' => $page,
            'title' => $page->name,
        ]);
    }

    public function create()
    {
        $categories = \App\Models\Category::pluck('name', 'id');
        $title = ! auth()->check() ? 'Guest post submit' : 'Post submit';

        return view('home.create', compact('categories', 'title'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'thumbnail' => 'required_without:youtube_url|mimes:jpeg,png,jpg,webp,svg,mp4,mov,avi,mp3,wav,ogg,aac,m4a|max:20480000000000000000',
            'guest_name' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        // Store thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('', 'public');
        }

        if (auth()->check()) {
            $data['user_id'] = auth()->user()->id;
            $data['status'] = 0;
        } else {
            $data['is_guest'] = true;
            $data['status'] = 0;
        }

        Post::create($data);

        return redirect()->back()->with('success', 'পোস্টটি সফলভাবে যুক্ত হয়েছে এবং বর্তমানে এটি অনুমোদনের অপেক্ষায় আছে।');
    }

    // In PostController
    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,webp,mp4,webm,mov,avi,mp3,wav,ogg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:20480',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first('file'),
            ], 422);
        }

        $path = $request->file('file')->store('markdown-uploads', 'public');

        return response()->json([
            'url' => asset('storage/'.$path),
        ]);
    }
}
