@extends('layout.app')

@section('content')
    <div class="row">
            <div class="col-sm-12 mt-3">
                <!-- Hero -->
<div class="p-5 text-center bg-image rounded-3" style="
    background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/041.webp');
    height: 400px;
  ">
  <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="text-white">
        <h1 class="mb-3">World FIshing</h1>
        <h4 class="mb-3">Fishin day is very enjoyable</h4>
      </div>
    </div>
  </div>
</div>
<!-- Hero -->

@foreach($posts as $post)
<div class="col-4 col-sm-6 mt-3" style="padding-right:0px" >
            <a href="https://dcpd.digantait.com/post/category/15" class="post_box home post_box_4">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <img src="{{ asset($post->thumbnail) }}" alt="" class="img-fluid home_icons">
                    </div>
                    <div class="col-12 col-sm-9">
                        <p><span>{{ $post->title }}</span></p>
                    </div>
                </div>
            </a>
        </div>
@endforeach

            </div>
        </div>
        
       
    
@endsection