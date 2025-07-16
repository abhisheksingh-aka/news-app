@extends('includes.default')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                @if(\Illuminate\Support\Facades\Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle me-2"></i>{{ \Illuminate\Support\Facades\Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin_login_success') }}" id="login">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" id="submit" style="background-color:#ee6315; color:#fff; border:none" class="btn btn-primary">Submit</button>
                        </form>
                        <div class="row">
                            <div class="col-sm-12"><p class="float-end"><a href="{{ route('admin_forgot_password') }}" style="color:#fff;" class="btn btn-link rounded-pill m-2">Forgot Password</a></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional, for Bootstrap's JavaScript plugins) -->
@endSection
