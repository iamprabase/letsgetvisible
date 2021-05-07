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
          <h3>Contact Us</h3>
          <nav class="brad_cam_lists">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('main')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Contact</li>
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
    <h2>Messages from Contact Form</h2>
    <div class="d-none d-sm-block mb-5 pb-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>
              Name
            </th>
            <th>
              Email
            </th>
            <th>
              Subject
            </th>
            <th>
              Message
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($contacts as $contact)
          <tr>
            <td>
              {{$contact->name}}
            </td>
            <td>
              {{$contact->email}}
            </td>
            <td>
              {{$contact->subject}}
            </td>
            <td>
              {{$contact->message}}
            </td>
          </tr>

          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
<!-- ================ contact section end ================= -->
@endsection
