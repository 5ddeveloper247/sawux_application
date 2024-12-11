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
            font-size: 1em !important;
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
@section('title', 'Login')

<div class="w-100 my-3" style="background-color:#65cb02; height:15px;"></div>

@section('content')

    <section class="login d-flex align-items-center justify-content-center" style="background-image:unset;">

        <div class="container-fluid h-100">
            <div class="row ">
                <div class="col-md-6 col-12">
                    <div class="d-flex justify-content-center align-items-center h-100">

                        <img class="" src="{{ asset('assets/images/logo-new.png') }}" alt="phoenix" width="200">
                    </div>
                </div>
                <div class="col-md-6 col-12  p-5 h-100 text-center d-flex flex-column justify-content-center">
                    <div class="text-start ">
                        <h1 class="text-center" style="color:#65cb02;">
                            SUPER ADMIN LOGIN
                        </h1>


                        <form id="emailVerifyForm">

                            <div class="mt-4" id="emailField">
                                <label for="">Email</label>
                                <br>
                                <input class="w-100 p-2 mt-1" id="email" type="text"
                                    placeholder="Enter your email address" name="email">
                            </div>
                            <div class="mt-4" id="otpField">
                                <label for="">OTP</label>
                                <br>
                                <input class="w-100 p-2 mt-1" type="number" id="otp" placeholder="Enter your otp"
                                    name="otp">
                            </div>
                            <div class="mt-4" id="passwordField">
                                <label for="">Password</label>
                                <br>
                                <input class="w-100 p-2 mt-1" type="text" id="password"
                                    placeholder="Enter your password" name="password">
                            </div>
                            <div class="mt-4" id="confirmdPasswordField">
                                <label for="">Confirmd Password</label>
                                <br>
                                <input class="w-100 p-2 mt-1" type="text" id="confirmPassword"
                                    placeholder="Enter your confirmed password" name="password_confirmation">
                            </div>
                            <button type="button" class="py-2 px-4 mt-4 mb-3 w-100" onclick="emailVerified(event)"
                                style="background-color:#65cb02; color: #fff;" id="saveParameter_btn">
                                Email Verify
                            </button>
                            <button type="button" class="py-2 px-4 mt-4 mb-3 w-100" onclick="OTPVerified(event)"
                                style="background-color:#65cb02; color: #fff;" id="otpverified_btn">
                                OTP Verify
                            </button>
                            <button type="button" class="py-2 px-4 mt-4 mb-3 w-100" onclick="updatePassword(event)"
                                style="background-color:#65cb02; color: #fff;" id="updatepassword_btn">
                                Update Password
                            </button>
                        </form>
                    </div>
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

@push('script')
    <script>
        $(document).ready(function() {

            $('#otpverified_btn').hide();
            $('#updatepassword_btn').hide();
            $('#confirmdPasswordField').hide();
            $('#passwordField').hide();
            $('#otpField').hide();
        });
        // email verify
        function emailVerified(event) {
            event.preventDefault();
            let type = 'POST';
            let url = '/email-verified';
            let message = '';
            let form = $('#emailVerifyForm');
            let data = new FormData(form[0]);
            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            SendAjaxRequestToServer(type, url, data, '', emailVerifiedResponse, '', '#saveParameter_btn');
        }

        function emailVerifiedResponse(response) {
            console.log(response.status);
            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.status == 200 || response.status == '200') {
                $("#email").val(response.data.email);
                $("#email").prop('readonly', true);
                $('#saveParameter_btn').hide();
                $('#otpverified_btn').show();
                $('#otpField').show();
                toastr.success('OTP has been sent to your email.', {
                    timeOut: 3000
                });

            } else {

                if (response.status == 402) {

                    error = response.message;

                } else {
                    error = response.responseJSON.message;
                    var is_invalid = response.responseJSON.errors;

                    $.each(is_invalid, function(key) {
                        // Assuming 'key' corresponds to the form field name
                        var inputField = $('[name="' + key + '"]');
                        // Add the 'is-invalid' class to the input field's parent or any desired container
                        inputField.closest('.form-control').addClass('is-invalid');
                    });
                }
                toastr.error(error, '', {
                    timeOut: 3000
                });
            }
        }
        // otp verified
        function OTPVerified(event) {
            event.preventDefault();
            let type = 'POST';
            let url = '/otp-verified';
            let message = '';
            let form = $('#emailVerifyForm');
            let data = new FormData(form[0]);
            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            SendAjaxRequestToServer(type, url, data, '', otpVerifiedResponse, '', '#otpverified_btn');
        }

        function otpVerifiedResponse(response) {
            console.log(response.status);
            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.status == 200 || response.status == '200') {
                $("#otp").prop('readonly', true);
                $('#saveParameter_btn').hide();
                $('#otpverified_btn').hide();
                $('#otpField').hide();
                $('#passwordField').show();
                $('#confirmdPasswordField').show();
                $('#updatepassword_btn').show();
                toastr.success('OTP has been verified successfully', {
                    timeOut: 3000
                });

            } else {

                if (response.status == 402) {

                    error = response.message;

                } else {
                    error = response.responseJSON.message;
                    var is_invalid = response.responseJSON.errors;

                    $.each(is_invalid, function(key) {
                        // Assuming 'key' corresponds to the form field name
                        var inputField = $('[name="' + key + '"]');
                        // Add the 'is-invalid' class to the input field's parent or any desired container
                        inputField.closest('.form-control').addClass('is-invalid');
                    });
                }
                toastr.error(error, '', {
                    timeOut: 3000
                });
            }

        }
        // update password
        function updatePassword(event) {
            event.preventDefault();
            let type = 'POST';
            let url = '/update-password';
            let message = '';
            let form = $('#emailVerifyForm');
            let data = new FormData(form[0]);
            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            SendAjaxRequestToServer(type, url, data, '', updatePasswordResponse, '', '#otpverified_btn');
        }

        function updatePasswordResponse(response) {
            console.log(response.status);
            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.status == 200 || response.status == '200') {
               
                toastr.success('Password has been updated successfully.', {
                    timeOut: 3000
                });

                 setTimeout(() => {
                    window.location.href = "/admin";
                }, 1000); // Adjust the delay as neede
            } else {

                if (response.status == 402) {

                    error = response.message;

                } else {
                    error = response.responseJSON.message;
                    var is_invalid = response.responseJSON.errors;

                    $.each(is_invalid, function(key) {
                        // Assuming 'key' corresponds to the form field name
                        var inputField = $('[name="' + key + '"]');
                        // Add the 'is-invalid' class to the input field's parent or any desired container
                        inputField.closest('.form-control').addClass('is-invalid');
                    });
                }
                toastr.error(error, '', {
                    timeOut: 3000
                });
            }

        }
    </script>
@endpush
