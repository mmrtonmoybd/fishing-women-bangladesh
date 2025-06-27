@extends('layout.app')
@section('content')
                        <div class="row">
            <div class="col-sm-12">
                <br>
                <center><h1 style="color:#CCC"> আপনার প্রোফাইল </h1></center>
                 <br>
                 @include('layout.flash-message')
                 
                 <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>নামঃ</th><td>{{ auth()->user()->name }}</td></tr>
                    <tr><th>মোবাইল ঃ</th><td>{{ auth()->user()->phone }}</td></tr>
                    <tr><th>মোট পোস্ট সংখ্যা ঃ</th><td>{{ \App\Models\Post::where('user_id', auth()->user()->id)->count() }}</td></tr>
                    <tr><th></th><td><a href="{{ route('user.profile.edit') }}">প্রোফাইল পরিবর্তন করুন</a></td></tr>
                </tbody>
            </table>

            <center><h3>আপনার সব পোস্ট</h3></center>
            
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>টাইটেল</th>
                    <th>তারিখ</th>
                    <th>অ্যাকশান</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d-m-Y')}}</td>
                    <td>
                        <a href="{{ route('post.id', $post->id) }}" class="text-primary mr-2">
                            <i class="fa fa-eye"></i> পোস্টটি দেখুন
                        </a>
                        <a href="{{ route('user.post.edit', $post->id) }}" class="text-warning mr-2">
                            <i class="fa fa-edit"></i> পোস্টটি এডিট করুন
                        </a>
                        <a href="{{ route('user.post.delete', $post->id) }}" class="text-danger" onclick="return confirm('আপনি কি নিশ্চিতভাবে ডিলিট করতে চান?');">
                            <i class="fa fa-trash"></i> পোস্টটি ডিলিট করুন
                        </a
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $posts->links() }}
            </div>
        </div>
@endsection