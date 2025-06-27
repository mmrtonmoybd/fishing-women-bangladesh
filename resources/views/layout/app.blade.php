
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2a0071">
    <link rel="apple-touch-icon" href="/logo192.png">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel='stylesheet' id='google_font-css'  href='https://fonts.googleapis.com/css?family=Montserrat%3A400%2C400i%2C500%2C500i%7CRoboto%3A400%2C400i%2C500%2C500i%2C700%2C700i%2C900%2C900i&#038;display=swap&#038;ver=1.0.0' type='text/css' media='all' />
     <!-- Local versioned CSS -->
    @php
        $styleVersion = file_exists(public_path('asset/style.css')) ? filemtime(public_path('asset/style.css')) : time();
    @endphp
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}?v={{ $styleVersion }}">
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
/>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">


    <title>{{ $title . ' | ' . config('app.name') ?? 'Page' .  ' | ' . config('app.name') }}</title>
    
  </head>
  <body class="">
  
   <div class="overlay" id="menu_overlay"></div>
   
   <nav id="sidebar">
        <div id="dismiss">
            <i class="fa fa-arrow-left"></i>
        </div>

        <div class="sidebar-header">
            <h1 class="header_text">
               {{ getSettingValue('general.brand_name') }}
            </h1>
            @php
            $slidemenuhm = App\Models\Slider::where('status', true)->where('position', 1)->first();
            @endphp
            <img src="{{ asset('/storage/' . $slidemenuhm?->image) }}" alt="" class="img-fluid">
        </div>

        <ul class="list-unstyled components">
            
            @include('layout.sidebar')
        </ul>

    </nav>
   
   
   
   
    <section class="header_top fixed-top">
        <div class="container">
            <div class="row">
                <div class="col-3 text-center">
                    <div class="p-2">
                      <button type="button" class="btn btn-primary navbar-toggle toggle_bar menu_bar" id="sidebarCollapse" style="display:block">
                            <i class="fa fa-bars"></i>
                        </button>
                    
                    </div>
                </div>
                <div class="col-6 text-center" style="padding:0px">
                    <h3> <a href="/" class="header_title">  {{ getSettingValue('general.brand_name') }} </a> </h3>
                </div>
                <div class="col-3 text-center">
                    <a href="/"><img src="{{ asset('/storage/' . getSettingValue('general.brand_logo')) }}" alt="" class="img-fluid"></a>
                </div>
            </div>
        </div>
    </section>
    
           <section class="home_section  top-padding">
    <div class="container mb-3 pb-3">
       
    @yield('content')

    </div>
</section>
<section class="home_content_section">
    <div class="container text-center">
        <div class="row home_tab_icons" style="">
            @php 
                        $headfoot = \App\Models\Page::where('position_type', 'footer')->orderBy('position', 'ASC')->get();
                        @endphp

                        @foreach($headfoot as $headfootdata)
            <div class="col-4 col-sm-4 single_icons" style="background: linear-gradient(90deg, #2a0071 0%, #7BFF9C 100%);
border: none;">
              <a href="{{ route('page.id', $headfootdata->id) }}">
                <h2> {{ $headfootdata->name }} </h2>
              </a>
            </div>

            @endforeach

            
            
        </div>
    </div>
</section>    
      
       <section class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-3">
                   <a href="/"><img style="max-width: 54px !important;" src="{{ asset('/storage/' . getSettingValue('general.brand_logo')) }}" alt="" class="img-fluid"></a>
                </div>
                <div class="col-6  text-center" style="padding-left:0px">
                    <p class="text-center">   {{ getSettingValue('general.brand_name') }} </p>
                    <p class="text-center">Develop by - <a target="_blank" href="https://engineerbd.net/"> Engineer BD Network </a></p>
                </div>
            </div>
        </div>
    </section>
    
    
    <script  src="https://code.jquery.com/jquery-3.3.1.min.js"  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!-- jQuery Custom Scroller CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    
        <script type="text/javascript">
            $(document).ready(function () {
               /* $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });
*/
                $('#dismiss, #menu_overlay').on('click', function () {
                    $('#sidebar').removeClass('active');
                    
                    $('#menu_overlay').removeClass('active');
                });

                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').addClass('active');
                    
                    $('#menu_overlay').addClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
            });
        </script>
        <script>$('.carousel').carousel(); </script>
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>


<script>
"use strict";
                if ("serviceWorker" in navigator) {
                    navigator.serviceWorker.register("/service-worker.js").then(
                        (registration) => {
                            console.log("Service worker registration succeeded:");
                        },
                        (error) => {
                            console.error("Service worker registration failed", error);
                        }
                    );
                } else {
                    console.error("Service workers are not supported.");
                }
</script>

<script>
  let deferredPrompt;

  // Only show install button if PWA is not installed
  function checkPWAInstallationStatus() {
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches
      || window.navigator.standalone === true;

    if (isStandalone) {
      // Already installed — hide the install button
      document.getElementById('installPwaBtn')?.remove();
    }
  }

  // Check right away if app is already installed
  window.addEventListener('load', () => {
    checkPWAInstallationStatus();
  });

  window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent the mini-infobar from appearing
    e.preventDefault();
    deferredPrompt = e;

    // Show install button if not installed
    const installBtn = document.getElementById('installPwaBtn');
    if (installBtn) installBtn.style.display = 'inline-block';
  });

  document.getElementById('installPwaBtn')?.addEventListener('click', async () => {
    if (deferredPrompt) {
      deferredPrompt.prompt();
      const { outcome } = await deferredPrompt.userChoice;

      if (outcome === 'accepted') {
        console.log('User accepted install prompt');
      } else {
        console.log('User dismissed install prompt');
      }

      deferredPrompt = null;

      // Hide the install button after decision
      document.getElementById('installPwaBtn')?.remove();
    }
  });
</script>


<!-- Use compatibility versions (with -compat suffix) -->
<script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-database-compat.js"></script>

<script>
(function () {
    "use strict";

    const isTWA = window.matchMedia('(display-mode: standalone)').matches
               && navigator.userAgent.includes("Chrome")
               && navigator.userAgent.includes("Android")
               && !window.matchMedia('(display-mode: browser)').matches;

    if (!isTWA || !navigator.onLine) return;

    const firebaseConfig = {
        apiKey: "AIzaSyCa7AgZ7kIAFEY-9hFq5-czcklSvesONXM",
        authDomain: "fishingwomen-d6293.firebaseapp.com",
        databaseURL: "https://fishingwomen-d6293-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "fishingwomen-d6293",
        appId: "1:869788173400:web:45a962d1dc0fda960df62d"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    firebase.database().ref('appStatus').once('value').then((snapshot) => {
        const status = snapshot.val();
        if (status === 0) {
            window.location.href = "/app-disabled.html";
        }
    }).catch(err => {
        console.error("TWA Firebase check failed:", err);
    });
})();
</script>

  </body>
</html>