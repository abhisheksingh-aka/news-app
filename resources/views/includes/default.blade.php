@php
    $current_url = URL::current() . '/';
    $web_url = Config::get('constants.server_host_url');
@endphp
        <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ isset($title) ? $title : ''}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@php header("X-Frame-Options: SAMEORIGIN"); @endphp
    @include('includes.head')
    @include('includes.stylesheet')
</head>
<body class="d-flex flex-column vh-100 ">
{{-- <main id="app"> --}}
    @include('includes.header')
    <section class="content-wrap">
        @yield('content')
        @yield('js_content')
        <div class="row mb-3">
        </div>
        {{--@include('website.cart.cart_detail')--}}
    </section>
{{--@include('website.category.category_js')--}}
{{--@include('website.common.autocomplete')--}}
    @include('includes.footer')
{{-- </main> --}}
@include('includes.javascript')
</body>
</html>