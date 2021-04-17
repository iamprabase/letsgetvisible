
@extends('layouts.app')

@section('content')

<!-- bradcam_area  -->
<div class="bradcam_area">
  <div class="bradcam_shap">
    <img src="img/ilstrator/bradcam_ils.png" alt="">
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="bradcam_text text-center">
          <h3>Sign Up</h3>
          <nav class="brad_cam_lists">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('main')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /bradcam_area  -->
<!-- ================ contact section start ================= -->
<section class="contact-section section_padding">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="contact-title">Details</h2>
      </div>
      <div class="col-md-6 offset-md-3">

        <form method="POST" action="{{ route('register') }}">
          @csrf
          <!-- <div class="row"> -->
          <div class="form-group">
            <label for="email" class="col-md-12 col-form-label">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
              value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="email" class="col-md-12 col-form-label">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
              value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="password" class="col-md-12 col-form-label">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
              name="password" required autocomplete="current-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror

          </div>

          <div class="form-group">
            <label for="password-confirm" class="col-md-12 col-form-label">{{ __('Confirm Password')
              }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
              autocomplete="new-password">
          </div>

          <!-- </div> -->
          <div class="form-group mt-3">
            <button type="submit" class="button button-contactForm btn_4 boxed-btn">Sign Up</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- ================ contact section end ================= -->

@endsection
