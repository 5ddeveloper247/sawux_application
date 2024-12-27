@extends('layouts.super_admin.master')

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
                <div class="d-flex align-items-center justify-content-center">
                    <img class="" src="{{ asset('assets/images/logo-new.png') }}" alt="phoenix" width="100">
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    <h2 class="text-center m-text mt-4">SUPER ADMIN LOGIN</h2>
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

                <form action="{{ route('superadmin.loginSubmit') }}" method="POST">
                    @csrf
                    <div class="mt-4">
                        <label for="" class="text-white">Username</label>
                        <br>
                        <input class="w-100 p-2 mt-1" type="text" placeholder="Enter Username" name="username">
                    </div>
                    <div class="mt-3">
                        <label for="" class="text-white">Password</label>
                        <br>
                        <input class="w-100 p-2 mt-1" type="password" placeholder="Enter Password" name="password">
                    </div>
                    <div class="form-options my-2 d-flex align-items-center justify-content-between gap-1">
                        <div class="remember-me d-flex gap-1">
                            <!-- <input type="checkbox" id="remember-me">
                                            <label class="form-label mb-1" for="remember-me">Remember me</label> -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div>
                            <a href="{{ route('superadmin.forgetpassword') }}" class="light-text text-capitalize">forget
                                password</a>
                        </div>
                    </div>
                    <button class="py-2 px-4 mt-4 mb-3 w-100 m-btn text-white rounded-2 fs-14" type="submit">
                        SIGN IN
                    </button>
                </form>
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
