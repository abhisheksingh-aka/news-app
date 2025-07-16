@php
    $version = 'version'.Date('Ymd');
    //$version = 'version1';
@endphp
<meta charset="utf-8">
<title>Admin</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="" name="keywords">
<meta content="" name="description">

<!-- Favicon -->
<link href="{{ asset('favicon.ico') }}" rel="icon">

<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Icon Font Stylesheet -->
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">--}}
<script language="JavaScript" type="text/javascript" src="{{ \Config::get('constants.secure_server_host_url') }}js/51e8f18c1b.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Libraries Stylesheet -->
<link href="{{ asset('admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
{{--<link rel="stylesheet" href="{{asset('vendors/bower_components/dropify/dist/css/dropify.min.css')}}">--}}
{{--<script type="text/javascript" src="{{asset('vendors/bower_components/dropify/dist/js/dropify.min.js')}}"></script>--}}
<!-- Customized Bootstrap Stylesheet -->
<link href="{{ asset('admin/css/bootstrap.min.css?'.$version) }}" rel="stylesheet">
<link href="{{ asset('admin/lib/select2/select2.min.css') }}" rel="stylesheet">
<!-- Template Stylesheet -->
<link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">