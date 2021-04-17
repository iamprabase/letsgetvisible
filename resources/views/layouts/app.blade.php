<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts/partials.header')

<body>

  @include('layouts/partials.navbar')

  @yield('content')

  @include('layouts/partials.footer')

</body>

</html>
