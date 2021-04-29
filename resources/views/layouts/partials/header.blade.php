<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{config('app.name')}}</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- <link rel="manifest" href="site.webmanifest"> -->
  <!-- Place favicon.ico in the root directory -->

  <!-- CSS here -->
  <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/flaticon.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/gijgo.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/slicknav.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
  <!-- <link rel="stylesheet" href="css/responsive.css"> -->

  <style>
    .hasDomainError{
      border-color: red!important;
      box-shadow: none!important;
    }

    .hidden{
      display: none;
    }

    #submit{
      background-color: #ffbd4a;
      color:#fff;
      font-size: 24px;
      width: 100%;
      padding: 8px;
      border-radius: 6px;
    }

    .search-box{
      width: 100%;
      padding: 15px 40px;
    }

    .loading{
      position: relative;
      top: 215px;
      text-align: center;
    }

    .loader {
      margin: auto;
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .opacity{
      opacity: 0.2;
    }
    .feature-block {
      border-radius: 50%;
      background-color: #d1d4da;
      box-shadow: inset 10px -3px 0px 10px rgb(13 23 142 / 57%);
      text-align: center;
      width: 30%;
      margin: auto;
      padding: 80px;
    }

    strong {
      color: #6a35ff;
      font-weight: 700;
    }

    .shadow {
      --tw-shadow: 0 1px 3px 0 rgba(0,0,0,0.1),0 1px 2px 0 rgba(0,0,0,0.06);
    }
  </style>
</head>
