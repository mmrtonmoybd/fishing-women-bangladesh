<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerform()
    {
        return view('auth.register', [
            'title' => 'একাউন্ট তৈরি',
        ]);
    }

    public function register(Request $request)
    {
        $phone = convertBengaliToEnglish($request->phone);
        $request->merge(['phone' => $phone]);
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ];

        User::create($data);

        return redirect()->route('user.login')->with('success', 'আপনার একাউন্টি সফল ভাবে তৈরি হয়েছে, এখন সেটি লগইন করতে পারবেন।');
    }

    public function loginform()
    {
        return view('auth.login', [
            'title' => 'লগইন করুন',
        ]);
    }

    public function login(Request $request)
    {
        $phone = convertBengaliToEnglish($request->phone);
        $request->merge(['phone' => $phone]);

        $request->validate([
            'phone' => 'required|string|exists:users,phone',
            'password' => 'required|string',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // 👇 Log out from all guards (e.g., admin)
            Auth::guard('web')->logout(); // in case already logged in
            // Auth::guard('admin')->logout(); // custom admin guard if used

            // 👇 Clear the session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // 👇 Log in new user and regenerate session
            Auth::login($user);
            $request->session()->regenerate();

            return redirect('/'); // or any user area
        }

        return back()->with([
            'error' => 'The provided credentials do not match our records.',
        ]);

    }

    public function profile()
    {
        return view('auth.profile', [
            'title' => 'প্রোফাইল',
            'posts' => Post::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(18),
        ]);
    }

    public function postdelete($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id == auth()->user()->id) {
            $post->delete();

            return back()->with([
                'success' => 'পোস্টটি সফল ভাবে মুছে ফেলা হয়েছে।',
            ]);
        } else {
            return back()->with([
                'error' => 'পোস্টটি সফল ভাবে মুছে ফেলা যায়নি।',
            ]);
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('user.login');
    }

    public function posteditshow($id)
    {
        // dd($id);
        $post = Post::findOrFail($id);

        if ($post->user_id != auth()->user()->id) {
            return redirect()->back()->with([
                'error' => 'পুররায় চেষ্টা করুন।',
            ]);
        }
        $categories = \App\Models\Category::pluck('name', 'id');
        $title = 'Post edit';

        return view('auth.edit-post', compact('categories', 'title', 'post'));
    }

    public function postedit($id, Request $request)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id != auth()->user()->id) {
            return redirect()->back()->with([
                'error' => 'পুররায় চেষ্টা করুন।',
            ]);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'thumbnail' => 'required_without:youtube_url|mimes:jpeg,png,jpg,webp,svg,mp4,mov,avi,mp3,wav,ogg,aac,m4a|max:20480000000000000000',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        // Store thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('', 'public');
        }

        $data['status'] = 0;

        $post->update($data);

        return redirect()->route('user.profile')->with('success', 'আপনার পোস্টটি সফল ভাবে আপডেট হয়েছে। এবং পুররায় প্রকাশের জন্য অপেক্ষমাণ রয়েছে।');
    }

    public function editprofileshow()
    {
        return view('auth.edit-profile', [
            'title' => 'Profile',
        ]);
    }

    public function editprofile(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.profile')->with('success', 'আপনার প্রোফাইল সফল ভাবে আপডেট হয়েছে।');
    }
}
