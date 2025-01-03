@extends('layouts.admin.admin_master')

@push('css')
    <style>
        .login {
            background-image: url('https://images.unsplash.com/photo-1591541924200-d1217b346bf6?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            height: 100vh;
            width: 100%;
            background-position: center;
            background-size: cover;
        }

        .login-content {
            background-color: #ffffff24;
            padding: 25px;
            border-radius: 10px;
            backdrop-filter: blur(5px)
        }
    </style>
@endpush
@section('title', 'Login')

@section('content')

    <section class="login d-flex align-items-center justify-content-center">

        <div class="container-fluid h-100 d-flex align-items-center justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 login-content">
                <div class="text-start ">
                    <div class="d-flex align-items-center justify-content-center">
                        <h2 class="text-center m-text mt-4">CUSTOMER LOGIN</h2>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @elseif($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('loginSubmit') }}" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label class="text-white" for="">Username</label>
                            <br>
                            <input class="w-100 p-2 mt-1" type="text" placeholder="Enter Username" name="username">
                        </div>
                        
                        <label for="password" class="text-white mt-3">Password</label>
                        <div class="position-relative">
                            <input class="w-100 p-2 mt-1" type="password" placeholder="Enter Password" name="password"
                                id="password">
                            <i class="fa-regular fa-eye toggle-password-icon position-absolute"
                                style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                id="togglePassword"></i>
                        </div>
                        <div class="form-options my-2 d-flex align-items-center justify-content-between gap-1">
                            <div class="remember-me d-flex gap-1">
                                <!-- <input type="checkbox" id="remember-me">
                                                <label class="text-white" class="form-label mb-1" for="remember-me">Remember me</label> -->
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div>
                                <a href="{{ route('forgetpassword') }}" class="light-text text-capitalize">forget
                                    password</a>
                            </div>
                        </div>
                        <button class="py-2 px-4 m-btn rounded-2 border-0 text-white mt-3 w-100" type="submit">
                            SIGN IN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/niceselect/nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/niceselect/custom-select.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/customjs/common.js') }}"></script>
    <script src="{{ asset('assets/customjs/main.js') }}"></script>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        const togglePasswordIcon = document.getElementById('togglePassword');

        togglePasswordIcon.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>
