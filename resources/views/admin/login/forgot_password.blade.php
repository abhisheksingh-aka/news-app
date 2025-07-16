@extends('includes.default')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin_forgot_password_success') }}" id="login">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <div class="row">
                            <div class="col-sm-12"><p class="float-end"><a href="{{ route('admin_login') }}" class="btn btn-link rounded-pill m-2">Login</a></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional, for Bootstrap's JavaScript plugins) -->
@endSection
