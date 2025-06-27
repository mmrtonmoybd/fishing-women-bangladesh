@extends('layout.app')
@section('meta')

<meta name="description" content="{{ Str::limit(strip_tags($post->content), 150) }}">
<meta name="keywords" content="{{ $post->category->name ?? 'News' }}, {{ $post->type }}">
<meta name="author" content="{{ $post->user->name ?? 'Guest' }}">

{{-- Open Graph / Facebook --}}
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:type" content="{{ $post->type === 'video' ? 'video.other' : 'article' }}">
<meta property="og:url" content="{{ Request::url() }}">
<meta property="og:image" content="{{ asset('storage/' . $post->thumbnail) }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($post->content), 150) }}">
<meta property="og:site_name" content="{{ config('app.name') }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $post->title }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($post->content), 150) }}">
<meta name="twitter:image" content="{{ asset('storage/' . $post->thumbnail) }}">
@endsection

@section('content')
<div class="container py-4">

<style>
.post-content {
    line-height: 1.8;
    font-size: 1.05rem;
    color: #333;
}
</style>



    {{-- Breadcrumb --}}
    <!--
    <div class="mb-4">
        <a href="{{ url('/') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
            ← Home
        </a>
        / <a href="{{ route('post.id', $post->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
            {{ $post->title }}
        </a>
    </div>
-->
<style>
    .post-headline {
  font-family: 'Georgia', serif; /* Classic newspaper feel */
  font-weight: 700;
  color: #1a1a1a;
  line-height: 1.2;
  margin-bottom: 0.5rem;
  word-break: break-word;
  text-align: center;

  /* Mobile default */
  font-size: 1.2rem;
}

/* Tablets */
@media (min-width: 576px) {
  .post-headline {
    font-size: 1.4rem;
  }
}

/* Small desktops */
@media (min-width: 768px) {
  .post-headline {
    font-size: 1.6rem;
  }
}

/* Large desktops */
@media (min-width: 1200px) {
  .post-headline {
    font-size: 1.8rem;
  }
}

</style>
    {{-- Post Header --}}
    <div class="text-center mb-4">
            <h1 class="post-headline">{{ $post->title }}</h1>

            <div class="text-muted small">
                <i class="fa fa-user"></i> {{ $post->user->name ?? 'Guest' }} &nbsp; • &nbsp;
                <i class="fa fa-calendar"></i> {{ $post->created_at->format('F j, Y') }} &nbsp; • &nbsp;
                <i class="fa fa-folder"></i> {{ $post->category->name ?? 'Uncategorized' }} &nbsp; • &nbsp;
                <i class="fa fa-tag"></i> {{ ucfirst($post->type) }}
            </div>
        </div>


    {{-- Media Section --}}
        <div class="mb-4">
            @php
                // Get YouTube ID
                $youtubeId = null;
                if (!empty($post->youtube_url)) {
                    preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([^\?&"\'\/]+)/', $post->youtube_url, $matches);
                    $youtubeId = $matches[1] ?? null;
                }
            @endphp

            {{-- YouTube Video --}}
            @if($youtubeId)
                <div class="videoWrapper push-up-10push-up-10 embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item"
                        src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allowfullscreen scrolling="no"></iframe>
                </div>

            {{-- Local Video --}}
            @elseif($post->type === 'video')
                <div class="ratio ratio-16x9 mb-3 rounded shadow-sm overflow-hidden">
                    <video controls preload="metadata" class="w-100 h-100">
                        <source src="{{ asset('storage/'.$post->thumbnail) }}" type="video/mp4">
                        আপনার ব্রাঊজারে ভিডিও টি সাপোর্ট করে না।
                    </video>
                </div>

            {{-- Audio --}}
            @elseif($post->type === 'audio')
                <div class="ratio ratio-16x9 mb-3 rounded shadow-sm overflow-hidden d-flex align-items-center justify-content-center bg-light">
                    <audio controls class="w-100">
                        <source src="{{ asset('storage/' . $post->thumbnail) }}" type="audio/mpeg">
                        আপনার ব্রাঊজারে অডিও টি সাপোর্ট করে না।
                    </audio>
                </div>

            {{-- Image --}}
            @else
                <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}"
                    class="img-fluid rounded shadow-sm w-100 mb-3" style="max-height: 500px; object-fit: cover;">
            @endif
        </div>



    {{-- Post Content --}}
    <div class="post-content bg-light p-4 rounded shadow-sm">
        {!! str($post->content)->markdown()->sanitizeHtml() !!}
    </div>

    <style>
.social-share {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.social-share .btn i {
    margin-right: 5px;
}
</style>
<center>
        {{-- Social Share Buttons --}}
    <div class="mt-4">
        <h5>সোশ্যাল মেডিয়ায় শেয়ার করুনঃ</h5>
        <div class="social-share d-flex flex-wrap gap-2 mt-2 justify-content-center">
            <a class="btn btn-sm btn-primary" target="_blank"
               href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}">
                <i class="fa fa-facebook"></i> Facebook
            </a>

            <a class="btn btn-sm btn-success" target="_blank"
               href="https://wa.me/?text={{ urlencode(Request::url()) }}">
                <i class="fa fa-whatsapp"></i> WhatsApp
            </a>

            <a class="btn btn-sm btn-info" target="_blank"
               href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ urlencode($post->title) }}">
                <i class="fa fa-twitter"></i> Twitter
            </a>

            <a class="btn btn-sm btn-danger" target="_blank"
               href="https://plus.google.com/share?url={{ urlencode(Request::url()) }}">
                <i class="fa fa-google-plus"></i> Google+
            </a>

            <a class="btn btn-sm btn-dark" target="_blank"
               href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode(Request::url()) }}">
                <i class="fa fa-envelope"></i> Email
            </a>

            <a class="btn btn-sm btn-primary" target="_blank"
               href="https://imo.im/">
                <i class="fa fa-commenting"></i> IMO
            </a>
        </div>
    </div>
</center>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function generatePDF() {
        const element = document.querySelector('.post-content');
        html2pdf().from(element).save("{{ Str::slug($post->title) }}.pdf");
    }
</script>

@endsection
