<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@php header("X-Frame-Options: SAMEORIGIN"); @endphp
    @include('admin.includes.head')
    @include('admin.includes.stylesheet')
</head>
<body>
{{-- <main id="app"> --}}
<div class="container-xxzl position-relative  d-flex p-0 bg_color">
    @php $clientUser=\Illuminate\Support\Facades\Session::get('clientUser');
    if(!$clientUser) {
        header("Location: " . \Illuminate\Support\Facades\URL::to('/admin/login'), true, 302);
        exit();
    }
    @endphp
    @include('admin.includes.sidebar')
    <div class="content">
        @include('admin.includes.header')
        @yield('content')
        @include('admin.includes.footer')
    </div>
<!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
{{-- </main> --}}
@include('admin.includes.javascript')
@yield('js_content')

</body>
</html>