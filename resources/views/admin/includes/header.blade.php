<!-- Navbar Start -->
<nav class="navbar navbar-expand bg_color navbar-light sticky-top px-4 py-0">
    <a href="#0" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">

        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                @if(Session('clientUser')->image != '')
                    <img class="rounded-circle me-lg-2" src="{{ \Config::get('constants.secure_server_host_url') }}profile/{{ Session('clientUser')->image }}" alt="" style="width: 40px; height: 40px;">
                @else
                    <i class="fa fa-user-shield fa-lg"></i>
                @endif
                <span class="d-none d-lg-inline-flex">{{ ucfirst(strtolower($clientUser['first_name'])) }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
               {{-- <a href="#" class="dropdown-item">My Profile</a>
                <a href="#" class="dropdown-item">Settings</a>--}}
                <a href="{{ route('admin_logout') }}" class="dropdown-item">Logout</a>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->