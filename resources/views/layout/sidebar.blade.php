<li><a href="/"><i class="fa fa-home"> </i>  হোম  </a></li>
<li><a href="{{ route('posts.create') }}"><i class="fa fa-pencil-square-o"> </i>  পোস্ট করুণ  </a></li>

                        @php 
                        $headpage = \App\Models\Page::where('position_type', 'header')->orderBy('position', 'ASC')->get();
                        @endphp

                        @foreach($headpage as $headpagedata)
<li><a href="{{ route('page.id', $headpagedata->id) }}"><i class="fa fa-dot-circle-o"> </i> {{ $headpagedata->name }}</a></li>
                        @endforeach
@if(!auth()->check())
<li><a href="{{ route('user.login') }}"><i class="fa fa-user-circle-o"> </i>  লগইন করুন  </a></li>
@else
<li><a href="{{ route('user.profile') }}"><i class="fa fa-user"> </i>  প্রোফাইল  </a></li>
<li><a href="{{ route('user.logout') }}"><i class="fa fa-sign-out"> </i>  লগ-আউট  </a></li>
@endif
<!-- Install PWA Button -->
            <li>
                <button id="installPwaBtn" class="btn btn-sm btn-primary" style="display: none; margin-top: 5px;">
                <i class="fa fa-download"></i> Install App
                </button>
            </li>