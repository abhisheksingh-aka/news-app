<!-- Sidebar Start -->
@php $controller = class_basename(request()->route()->getAction('controller'));
list($controller, $action) = explode("@", $controller);
$newsController = ['NewsController'];
@endphp
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg_color_sd navbar-light">
        <a href="{{ route('news') }}" class="navbar-brand mx-4 mb-3">
            <img src="{{ \Config::get('constants.secure_server_host_url') }}Images/logo.png"/>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                @if(Session('clientUser')->image != '')
                    <img class="rounded-circle me-lg-2" src="{{ \Config::get('constants.secure_server_host_url') }}profile/{{ Session('clientUser')->image }}" alt="" style="width: 40px; height: 40px;">
                @else
                    <i class="fa fa-user-shield fa-lg"></i>
                @endif
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h5 class="mb-0">{{ ucfirst(strtolower($clientUser['name'])) }}</h5>
            </div>
        </div>
        <div class="navbar-nav w-100">
                <a href="{{ route('news') }}" class="nav-item nav-link <?= in_array($controller, $newsController) ? 'active' : '' ?>"><i
                        class="fa fa-icons me-2"></i>News</a>
        </div>
    </nav>
</div>
<!-- Sidebar End -->