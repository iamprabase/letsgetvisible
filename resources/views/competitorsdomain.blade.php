@extends('layouts.app')

@section('content')

<!-- slider_area_start -->
<div class="slider_area">
  <div class="shap_img_1 d-none d-lg-block">
    <img src="{{ asset('frontend/img/ilstrator/body_shap_1.png') }}" alt="">
  </div>
  <div class="poly_img">
    <img src="{{ asset('frontend/img/ilstrator/poly.png') }}" alt="">
  </div>
  <div class="single_slider  d-flex align-items-center slider_bg_1">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-10 offset-xl-1">
          <div class="slider_text text-center">
            <div class="text">
              <h3>
                SERP Competitors
              </h3>
              <a class="boxed-btn3" href="#domain">Get Started</a>
            </div>
            <div class="ilstrator_thumb">
              <img src="{{ asset('frontend/img/ilstrator/illustration.png') }}" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- slider_area_end -->
<div class="col-md-12 loading hidden">
  <div class="loader"></div>
  <h3>Loading...</h3>
</div>
<!-- case_study_area  -->
<div class="case_study_area case_bg_1">
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="section_title text-center mb-95" style="text-align: center;color: #747474">
          <h3>Enter Keywords to get Google Reviews </h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-12">
        <div class="row">
          <div class="col-md-12 text-center">
            <form method="post" action="{{route('getCompetitorsdomain')}}" id="competitor-form">
              @csrf
              <div class="row">
                <div class="col-md-5">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">https://</span>
                    <input id="domain" class="form-control search-box input-hg" name="domain" type="text"
                      placeholder="Domain" required>
                  </div>
                  <span class="errField hidden" style="color:red">Invalid Domain</span>
                </div>
                <div class="col-md-5">
                  <div class="input-group-prepend">
                    <input id="location" class="form-control search-box input-hg" name="location" type="text"
                      placeholder="location" required>
                  </div>
                  <span class="errField hidden" style="color:red">Invalid Domain</span>
                </div>
                <div class="col-md-2">
                  <button id="submit" type="submit" class="btn btn-default">
                    <span class="qodef-btn-text">Get Review</span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-md-12 seoScoreDiv">

      </div>
      <div class="col-md-12">
        <div class="row seoDetailsDiv">

        </div>
      </div>
    </div>
  </div>
</div>
<!--/ case_study_area  -->
@endsection
