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

        #otpField,
        #passwordField,
        #confirmdPasswordField,
        #otp-container,
        #otpverified_btn,
        #updatepassword_btn {
            display: none;

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
                        <img class="" src="{{ asset('assets/images/logo-new.png') }}" alt="phoenix" width="100">
                    </div>

                    <div class="d-flex align-items-center justify-content-center">
                        <h2 class="text-center m-text mt-4">SUPER ADMIN LOGIN</h2>
                    </div>


                    <form id="emailVerifyForm">

                        <div class="mt-4" id="emailField">
                            <label style="color: white" for="">Email</label>
                            <br>
                            <input class="w-100 p-2 mt-1" id="email" type="text"
                                placeholder="Enter your email address" name="email">
                        </div>

                        <div class="mt-4" id="otpField">
                            <label style="color: white" for="">OTP</label>
                            <br>
                            <input class="w-100 p-2 mt-1" type="number" id="otp" placeholder="Enter your otp"
                                name="otp">
                        </div>
                        <div id="otp-container">
                            <div
                                style="display:flex;  align-items: center; justify-content: end; margin: 10px auto; font-family: Arial, sans-serif;">

                                <p id="timer" style="margin: 0; font-size: 14px; color:white; text-align: right;">
                                    Resend available in
                                    <span id="time" style="font-weight: bold; color: #FF5733;">30</span> seconds
                                </p>
                                <button id="resend-otp" class="mx-2 btn btn-sm btn-primary">
                                    Resend OTP
                                </button>
                            </div>
                        </div>

                        <div class="mt-4" id="passwordField">
                            <label style="color: white" for="">Password</label>
                            <div class="position-relative">
                                <input class="w-100 p-2 mt-1" type="password" id="password"
                                    placeholder="Enter your password" name="password">
                                <i class="fa-regular fa-eye toggle-password-icon position-absolute"
                                    style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                    id="togglePassword"></i>
                            </div>
                        </div>

                        <div class="mt-4" id="confirmdPasswordField">
                            <label style="color: white" for="">Confirm Password</label>
                            <div class="position-relative">
                                <input class="w-100 p-2 mt-1" type="password" id="confirmPassword"
                                    placeholder="Enter your confirmed password" name="password_confirmation">
                                <i class="fa-regular fa-eye toggle-password-icon position-absolute"
                                    style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                    id="toggleConfirmPasswordIcon"></i>
                            </div>
                        </div>

                        <button type="button" class="py-2 px-4 m-btn rounded-2 border-0 text-white mt-4 mb-3 w-100"
                            onclick="emailVerified(event)" id="saveParameter_btn">
                            Email Verify
                        </button>
                        <button type="button" class="py-2 px-4 m-btn rounded-2 border-0 text-white mt-4 mb-3 w-100"
                            onclick="OTPVerified(event)" id="otpverified_btn">
                            OTP Verify
                        </button>
                        <button type="button" class="py-2 px-4 m-btn rounded-2 border-0 text-white mt-4 mb-3 w-100"
                            onclick="updatePassword(event)" id="updatepassword_btn">
                            Update Password
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

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility function
            const toggleVisibility = (inputId, iconId) => {
                const inputField = document.getElementById(inputId);
                const toggleIcon = document.getElementById(iconId);

                toggleIcon.addEventListener('click', function() {
                    // Toggle the input field type
                    const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                    inputField.setAttribute('type', type);

                    // Toggle the icon class
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            };

            // Initialize toggle functionality for both fields
            toggleVisibility('password', 'togglePassword');
            toggleVisibility('confirmPassword',
                'toggleConfirmPasswordIcon'); // Use correct icon ID for confirmed password
        });



        $(document).ready(function() {
            $("#otp-container").hide();
            $('#otpverified_btn').hide();
            $('#updatepassword_btn').hide();
            $('#confirmdPasswordField').hide();
            $('#passwordField').hide();
            $('#otpField').hide();
        });
        let timerDuration = 30; // Timer duration in seconds
        let timerInterval;

        function startTimer() {
            let timeLeft = timerDuration;
            $("#resend-otp").prop("disabled", true); // Disable button
            $("#timer").show();

            timerInterval = setInterval(function() {
                timeLeft--;
                $("#time").text(timeLeft);

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    $("#resend-otp").prop("disabled", false); // Enable button
                    $("#timer").hide();
                }
            }, 1000);
        }

        // Start the timer on page load


        // Handle resend button click
        $("#resend-otp").click(function(e) {
            e.preventDefault();
            $("#resend-otp").prop("disabled", true);
            let type = 'POST';
            let url = '/customer/email-verified';
            let message = '';
            let form = $('#emailVerifyForm');
            let data = new FormData(form[0]);
            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            SendAjaxRequestToServer(type, url, data, '', emailVerifiedResponse, '', '#saveParameter_btn');
        });
        // email verify
        function emailVerified(event) {
            event.preventDefault();
            let type = 'POST';
            let url = '/customer/email-verified';
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
                $("#otp-container").show();
                startTimer();
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
            let url = '/customer/otp-verified';
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
                $("#otp-container").hide();
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
            let url = '/customer/update-password';
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
                    window.location.href = "/login";
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
