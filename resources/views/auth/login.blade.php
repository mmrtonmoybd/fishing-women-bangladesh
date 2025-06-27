@extends('layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
<br>
            <div class="card">
                @include('layout.flash-message')
                <div class="card-header">লগইন করুন</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">মোবাইল নাম্বার</label>

                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">পাসওয়ার্ড</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    লগইন
                                </button>

                                
                                    <a class="btn btn-link" href="{{ route('user.register') }}">
                                        একাউন্ট তৈরি করুন
                                    </a>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection