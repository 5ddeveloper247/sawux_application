@extends('layouts.super_admin.master')

@push('css')
<style>

.login-content2 {
    position: relative;
    color: #fff;
}

.login-content2::after {
    content: '';
    position: absolute;
    background-color: rgba(0, 0, 0, 0.6);
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
}

.heading {
    position: relative;
    z-index: 9;
    font-size: clamp(28px, 4vw, 37px);
}

.heading span {
    background-color: #FFD500;
    color: var(--second-primary-color);
    font-size:1em !important;
}

.testimonial-slider p {
    font-size: 14px;
}

.forgot-password {
    color: #28574E;
    text-decoration: none;
    font-size: 14px;
}

.form-options .remember-me {
    display: flex;
    align-items: center;
}

.form-options .remember-me input {
    margin-right: 5px;
}

.form-control {
    font-size: 14px;
}

.or {
    position: relative;
}

.or::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 140%;
    border: 0.5px solid #dbdbdb;
    width: 16vw;
}

.or::before {
    content: '';
    position: absolute;
    top: 50%;
    right: 140%;
    border: 0.5px solid #dbdbdb;
    width: 16vw;
} 
</style>
@endpush
@section('title','Login')

<div class="w-100 my-3" style="background-color:#65cb02; height:15px;"></div>

@section('content')

<section class="login d-flex align-items-center justify-content-center" style="background-image:unset;">
    
    <div class="container-fluid h-100">
        <div class="row ">
            <div class="col-md-6 col-12">
                <div class="d-flex justify-content-center align-items-center h-100">
                    
                    <img class="" src="{{asset('assets/images/logo-new.png')}}" 
                        alt="phoenix" width="200">
                </div>
            </div>
            <div class="col-md-6 col-12  p-5 h-100 text-center d-flex flex-column justify-content-center">
                <div class="text-start ">
                    <h1 class="text-center" style="color:#65cb02;">
                       SUPER ADMIN LOGIN
                    </h1>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{session('error')}}
                        </div>
                    @elseif($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{route('superadmin.loginSubmit')}}" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label for="">Username</label>
                            <br>
                            <input class="w-100 p-2 mt-1" type="text" placeholder="Enter Username" name="username">
                        </div>
                        <div class="mt-3">
                            <label for="">Password</label>
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
                            <a href="{{route('superadmin.forgetpassword')}}">forget password</a>
                            </div>
                        </div>
                        <button class="py-2 px-4 mt-4 mb-3 w-100" type="submit" style="background-color:#65cb02; color: #fff;">
                            SIGN IN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{asset('assets/plugins/niceselect/nice-select.min.js')}}"></script>
<script src="{{asset('assets/plugins/niceselect/custom-select.js')}}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/plugins/tagsinput/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{asset('assets/customjs/common.js')}}"></script>
<script src="{{asset('assets/customjs/main.js')}}"></script>

@endsection