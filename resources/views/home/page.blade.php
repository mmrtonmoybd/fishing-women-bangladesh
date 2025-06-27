@extends('layout.app')
@section('meta')

<meta name="description" content="{{ Str::limit(strip_tags($page->content), 150) }}">

{{-- Open Graph / Facebook --}}
<meta property="og:title" content="{{ $page->name }}">
<meta property="og:url" content="{{ Request::url() }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($page->content), 150) }}">
<meta property="og:site_name" content="{{ config('app.name') }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $page->name }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($page->content), 150) }}">
@endsection
@section('content')
<!--
<div class="row">
            <div class="col-sm-12 mt-3">
                <a href="/" class="post_box post_box_2" style="padding:5px">
                    <h3 style="font-size: 18px;margin: 0px;">Home </h3>
                </a>
            </div>
        </div>
-->
        <br>
                        <div class="row">
            <div class="col-sm-12">
                <center><h1 style="color:#CCC"> {{ $page->name }} </h1></center>
                 <br>
                 <p>{!! str($page->content)->sanitizeHtml() !!}</p>
            </div>
        </div>
@endsection