<!-- header-start -->
<header>
  <div class="header-area ">
    <div id="sticky-header" class="main-header-area">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-xl-3 col-lg-2">
            <div class="logo">
              <a href="{{route('main')}}">
                <h2>{{config('app.name')}}</h2>
              </a>
            </div>
          </div>
          <div class="col-xl-6 col-lg-7">
            <div class="main-menu  d-none d-lg-block">
              <nav>
                <ul id="navigation">
                  <li><a href="{{route('main')}}">Home</a></li>
                  <li><a href="{{route('contact')}}">Contact</a></li>
                  @auth
                  <li><a href="{{route('reviews')}}">Reviews</a></li>
                  <li><a href="{{route('competitorsdomain')}}">Competitors Domain</a></li>
                  @endauth
                </ul>
              </nav>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 d-none d-lg-block">
            <div class="Appointment">
              <div class="book_btn d-none d-lg-block">
                @if (Route::has('login'))
                @auth
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                 <i class="fa fa-key"></i> Sign Out
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
                @else
                <a href="{{route('login')}}"> <i class="fa fa-key"></i> Sign In</a>

                @if (Route::has('register'))
                <a href="{{route('register')}}"> <i class="fa fa-user"></i> Sign Up</a>
                @endif
                @endauth
                @endif
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="mobile_menu d-block d-lg-none"></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</header>
<!-- header-end -->
