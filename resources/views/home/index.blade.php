@extends('layout.app')
@section('meta')

<meta name="description" content="{{ getSettingValue('seo.description') }}">
<meta name="keywords" content="{{ getSettingValue('general.brand_name') }}, {{ getSettingValue('seo.description') }}, {{ getSettingValue('seo.title') }}">
<meta name="author" content="{{ getSettingValue('general.brand_name') }}">

{{-- Open Graph / Facebook --}}
<meta property="og:title" content="{{ getSettingValue('seo.title') }}">
<meta property="og:url" content="{{ Request::url() }}">
<meta property="og:image" content="{{ asset('/storage/' . getSettingValue('general.brand_logo')) }}">
<meta property="og:description" content="{{ getSettingValue('seo.description') }}">
<meta property="og:site_name" content="{{ getSettingValue('general.brand_name') }}">

{{-- Twitter Card --}}
<meta name="twitter:title" content="{{ getSettingValue('seo.title') }}">
<meta name="twitter:description" content="{{ getSettingValue('seo.description') }}">
<meta name="twitter:image" content="{{ asset('/storage/' . getSettingValue('general.brand_logo')) }}">
@endsection
@section('content')
    <div class="row">
            <div class="col-sm-12 mt-3">
                
               <style>
  .hero-swiper .swiper-slide {
    transition: transform 0.6s ease-in-out;
    height: 35vh;
    min-height: 200px;
    max-height: 400px;
  }

    /* Optional: larger size on desktop */
  @media (min-width: 992px) {
    .hero-title {
      font-size: 2rem;
    }
  }

  /* Optional: smaller size on small screens */
  @media (max-width: 576px) {
    .hero-title {
      font-size: 1.5rem;
    }
  }

  @media (min-width: 768px) {
    .hero-swiper .swiper-slide {
      height: 50vh;
    }
  }

  @media (min-width: 1200px) {
    .hero-swiper .swiper-slide {
      height: 60vh;
    }
  }

  .hero-swiper .swiper-slide > .h-100 {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  .hero-swiper .swiper-slide-active h1 {
    animation: fadeInUp 1s ease-out;
  }

  @keyframes fadeInUp {
    from {
      transform: translateY(20px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

    .hero-title {
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
      color: white;
      text-align: center;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);

      position: absolute;
      bottom: clamp(1.7rem, 4vw, 2rem); /* You already confirmed this is correct 10*/
      left: 50%;
      transform: translateX(-50%); /* Center horizontally */
      z-index: 10;

      font-size: clamp(1.2rem, 4vw, 2.5rem); /* Responsive size: adjusts based on viewport width 6*/
      max-width: 90%;
      white-space: nowrap;
    }



  /* Navigation buttons styling */
  .swiper-button-prev,
  .swiper-button-next {
    color: white;
    width: 40px;
    height: 40px;
    background: rgba(0, 0, 0, 0.4);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
  }

  .swiper-button-prev:hover,
  .swiper-button-next:hover {
    background: rgba(0, 0, 0, 0.7);
  }

  .swiper-button-prev::after,
  .swiper-button-next::after {
    font-size: 18px;
    font-weight: bold;
  }
</style>




<!-- Hero Section -->
<div class="swiper hero-swiper position-relative">
  <div class="swiper-wrapper">
    @foreach($slider as $img)
    <h1 class="hero-title">{{ getSettingValue('general.brand_name') }}</h1>
      <div class="swiper-slide">
        <div class="h-100 w-100" style="background-image: url('/storage/{{ $img->image }}'); background-size: cover; background-position: center;">
          <div class="h-100 w-100 d-flex justify-content-center align-items-center position-relative">
            
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.hero-swiper', {
      loop: true,
      autoplay: {
        delay: 3000, // Slide every 3 seconds
        disableOnInteraction: false,
      },
      speed: 800,
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      // Removed navigation to avoid getting stuck
    });
  });
</script>



<style>
.post-card {
    transition: box-shadow 0.3s ease-in-out, transform 0.2s;
}
.post-card:hover {
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    transform: translateY(-3px);
}

.play-icon {
    pointer-events: none;
    opacity: 0.9;
    text-shadow: 0 0 10px rgba(0,0,0,0.4);
}
.media-wrapper:hover .play-icon {
    opacity: 1;
}
</style>
<br>

<div class="row g-4">
    @foreach($posts as $post)
        <div class="col-12 col-md-6">
            <div class="post-card shadow-sm rounded-4 border bg-white h-100 d-flex flex-column overflow-hidden">
                
                {{-- Media Section --}}
                  <div class="media-wrapper position-relative" 
                      data-bs-toggle="{{ in_array($post->type, ['video', 'audio']) ? 'modal' : '' }}" 
                      data-bs-target="{{ in_array($post->type, ['video', 'audio']) ? '#videoModal' : '' }}" 
                      @if(in_array($post->type, ['video', 'audio'])) data-video="{{ asset('storage/' . $post->thumbnail) }}" @endif>

                      {{-- YouTube video --}}
                      @if(!empty($post->youtube_url))
                          @php
                              preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([^\?&"\'\/]+)/', $post->youtube_url, $matches);
                              $youtubeId = $matches[1] ?? null;
                              $youtubeThumb = $post->type === 'image' && $post->thumbnail ? asset('storage/' . $post->thumbnail) : "https://i.ytimg.com/vi/{$youtubeId}/sddefault.jpg";
                          @endphp

                          <a href="{{ route('post.id', $post->id) }}">
                              <img src="{{ $youtubeThumb }}" alt="{{ $post->title }}"
                                  class="img-fluid w-100 rounded-top" style="height: 220px; object-fit: cover;">
                          </a>

                      {{-- Video Post --}}
                      @elseif($post->type === 'video')
                          <video class="w-100 rounded-top object-fit-cover" muted preload="metadata" style="height: 220px; object-fit: cover; cursor:pointer;">
                              <source src="{{ asset('storage/' . $post->thumbnail) }}" type="video/mp4">
                              Your browser does not support the video tag.
                          </video>
                          <div class="play-icon position-absolute top-50 start-50 translate-middle text-white fs-1">
                              <i class="fa fa-play-circle"></i>
                          </div>

                      {{-- Audio Post --}}
                      @elseif($post->type === 'audio')
                          <div class="w-100 rounded-top bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                              <i class="fa fa-music fs-1 text-muted"></i>
                          </div>
                          <div class="play-icon position-absolute top-50 start-50 translate-middle text-white fs-1">
                              <i class="fa fa-play-circle"></i>
                          </div>

                      {{-- Image Post --}}
                      @else
                          <a href="{{ route('post.id', $post->id) }}">
                              <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}"
                                  class="img-fluid w-100 rounded-top" style="height: 220px; object-fit: cover;">
                          </a>
                      @endif
                  </div>


                {{-- Content Section --}}
                <div class="p-4 d-flex flex-column flex-grow-1">
                    <span class="text-muted small mb-2 d-block">
                        @php
                            $icon = match($post->type) {
                                'video' => 'video',
                                'audio' => 'music',
                                default => 'image',
                                'youtube' => 'youtube',
                            };
                        @endphp
                        <i class="fa fa-{{ $icon }}"></i>

                        {{ ucfirst($post->type) }} — {{ $post->created_at->format('M d, Y') }}
                    </span>

                    <h5 class="mb-2 fw-semibold text-dark">
                        <a href="{{ route('post.id', $post->id) }}" class="text-decoration-none text-dark">
                            {{ $post->title }}
                        </a>
                    </h5>

                    <p class="text-secondary small flex-grow-1 mb-3">
                        {{ Str::limit(strip_tags($post->content), 90) }}
                    </p>

                    <div>
                        <a href="{{ route('post.id', $post->id) }}" class="btn btn-sm btn-primary rounded-pill px-4">
                            আরো পড়ুন
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>




{{ $posts->links() }}

            </div>
        </div>
        
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark text-white">
      <div class="modal-body p-0">
        <video id="modalVideo" class="w-100" controls autoplay>
            <source src="" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
      </div>
    </div>
  </div>
</div>


  <script>
document.addEventListener("DOMContentLoaded", function () {
    const videoModal = document.getElementById('videoModal');
    const modalVideo = document.getElementById('modalVideo');

    videoModal.addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        const videoUrl = trigger.getAttribute('data-video');
        modalVideo.querySelector('source').setAttribute('src', videoUrl);
        modalVideo.load();
    });

    videoModal.addEventListener('hidden.bs.modal', function () {
        modalVideo.pause();
        modalVideo.currentTime = 0;
    });
});
</script>



@endsection