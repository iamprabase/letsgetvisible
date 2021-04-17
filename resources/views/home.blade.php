@extends('layouts.app')

@section('content')
<div class="shap_big_2 d-none d-lg-block">
  <img src="{{ asset('frontend/img/ilstrator/body_shap_2.png') }}" alt="">
</div>
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
                SEO AUDIT REPORT
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

<!-- case_study_area  -->
<div class="case_study_area case_bg_1">
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="section_title text-center mb-95" style="text-align: center;color: #747474">
          <h3>Enter an URL address and get a Free Website Analysis!</h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-12">
        <div class="row">
          <div class="col-md-12 text-center">
            <form id="website-form">
              <div id="row-main-top" class="form form-inline">
                <div class="col-md-10">
                  <input id="domain" class="form-control search-box input-hg" name="Website[domain]" type="text"
                    value="" placeholder="Example.com" style="
                        width: 100%;
                        padding: 15px 40px;
                    ">
                </div>
                <div class="col-md-2">
                  <a id="submit"
                    class="qodef-btn qodef-btn-medium qodef-btn-solid qodef-btn-hover-animation qodef-btn-orange"
                    target="_self" rel="noopener noreferrer"
                    style="background-color: #ffbd4a;color:#fff;margin-top: 0!important;vertical-align: top!important;/* margin-left: 5px; */font-size: 24px;height: 70px!important;width: 100%;padding: 10px;border-radius: 6px;">
                    <span class="qodef-btn-text">Audit</span>
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ case_study_area  -->
@endsection
