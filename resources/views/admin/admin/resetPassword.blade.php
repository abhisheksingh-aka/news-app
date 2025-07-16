@extends('admin.includes.default')
@section('content')
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">{{ $title }}</h6>
                    <form action="{{ route('admin_reset_password_success') }}" method="post" id="passwordResetForm">
                        @csrf
                        <div class="row mb-3 err_msg">
                        </div>
                        <div class="row mb-3">
                            <div class="row mb-6">
                                <div class="col-sm-7">
                                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input class="form-control" id="password" name="password" type="password">
                                            <span class="input-group-text"><i class="far fa-eye-slash" id="togglePassword"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <div class="col-sm-7">
                                    <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input class="form-control" id="confirm_password" name="confirm_password" type="password">
                                            <span class="input-group-text"><i class="far fa-eye-slash" id="toggleConfirmPassword"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(in_array('admin_reset_password', Session('capability')))
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->
@endSection
@section('js_content')
<script>
    $(document).off('click', "#togglePassword").on('click', "#togglePassword", function (e) {
        const password = document.querySelector("#password");
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        const class_val = password.getAttribute("type") === "password" ? "far fa-eye" : "far fa-eye-slash";
        password.setAttribute("type", type);
        $("#togglePassword").attr('class', class_val);
    });

    $(document).off('click', "#toggleConfirmPassword").on('click', "#toggleConfirmPassword", function (e) {
        const password = document.querySelector("#confirm_password");
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        const class_val = password.getAttribute("type") === "password" ? "far fa-eye" : "far fa-eye-slash";
        password.setAttribute("type", type);
        $("#toggleConfirmPassword").attr('class', class_val);
    });

    $('#passwordResetForm').on('submit',function(event){
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        if(password.length < 6) {
            $(".err_msg").html('The password must be at least 6 characters.');
            return false;
        }
        if(password !== confirm_password) {
          $(".err_msg").html('The password and confirm password value must be same.');
          return false;
        }
    });
</script>
@endSection
