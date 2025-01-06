{{--
    dd($api_settings);
--}}
@extends('layouts.super_admin.master')

@push('css')
@endpush

@section('content')
    <div class="px-3 py-4">
        <h3 class="m-text fw-semibold">Profile</h3>

        <div class="row g-0 align-items-start sub-bg rounded-4 p-4">
            <div class="col-2">
                <div class="form-floating  col-12 mb-3" id="previewImage">

                    @if ($data->profile)
                        <img src="{{ url($data->profile) }}" width="100%" height="220px" style="object-fit: cover"
                            class="rounded-3" alt="">
                    @else
                        <img src="https://images.unsplash.com/photo-1543610892-0b1f7e6d8ac1?w=1900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8cHJvZmlsZXxlbnwwfHwwfHx8MA%3D%3D"
                            width="100%" height="220" class="rounded-3 object-fit-cover" alt="">
                    @endif


                </div>
            </div>

            <div class="col-9 ps-4 d-flex align-items-start gap-3 justify-content-between">
                <div>
                    <h5 class="s-text fw-normal">Personal Details</h5>

                    <div class="d-flex flex-column mb-3">
                        <small class="light-text">Name:</small>
                        <span class="text-capitalize">{{ $data->name }}</span>
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <small class="light-text">Username:</small>
                        <span class="text-capitalize">{{ $data->username }}</span>
                    </div>
                    <div class="d-flex flex-column">
                        <small class="light-text">Email:</small>
                        <span>{{ $data->email }}</span>
                    </div>
                </div>

                <div class="col-6">
                    <div class="p-1 d-flex justify-content-start">
                        <h5 class="mb-0 m-text">Profile Update</h5>
                    </div>

                    <form id="passwordVerifyForm">
                        <label class="ms-2" for="">Profile Image</label>
                        <div class="col-12 mb-3">
                            <input type="file" class="form-control" id="image" name="image" accept=".png, .jpg, .jpeg" single
                                placeholder="" value="">
                        </div>
                        <small style="color: #6c757d; font-size: 0.9rem; display: block;"
                            class="form-text">
                            <i class="fas fa-info-circle"></i> The image must be in PNG or JPG format.
                        </small>

                        <div class="mb-3 mt-3">
                            <label for="currentpassword" class="form-label">Current Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="currentpassword" name="currentpassword"
                                    placeholder="Current Password" maxlength="50">
                                <i class="fa-regular fa-eye toggle-password-icon position-absolute"
                                    style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                    id="toggleCurrentPassword"></i>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="New Password" maxlength="50">
                                <i class="fa-regular fa-eye toggle-password-icon position-absolute"
                                    style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                    id="togglePassword"></i>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm New Password" maxlength="50">
                                <i class="fa-regular fa-eye toggle-password-icon position-absolute"
                                    style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                    id="toggleConfirmPassword"></i>
                            </div>
                        </div>


                        <div class="text-center">
                            <button type="button"
                                class="btn py-1 px-4 rounded-2 m-btn w-100  text-white border-0 update-profile">Profile
                                Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

            // Initialize toggle functionality for all fields
            toggleVisibility('currentpassword', 'toggleCurrentPassword');
            toggleVisibility('password', 'togglePassword');
            toggleVisibility('password_confirmation', 'toggleConfirmPassword');
        });


        $(document).ready(function() {
            $('#image').on('change', function() {
                const file = this.files[0]; // Get the selected file
                const preview = $('#previewImage'); // Image preview element

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.html(
                            `<img  src="${e.target.result}" class="rounded-3" width="100%" height="220px" style="object-fit: contain"  alt="image">`
                        );
                    };

                    reader.readAsDataURL(file); // Read the file as a data URL
                } else {
                    preview.html(`   @if ($data->profile)
                        <img src="{{ url($data->profile) }}" width="100%" height="220px" style="object-fit: contain"
                            class="rounded-3" alt="">
                    @else
                        <img src="https://images.unsplash.com/photo-1543610892-0b1f7e6d8ac1?w=1900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8cHJvZmlsZXxlbnwwfHwwfHx8MA%3D%3D"
                            width="100%" height="220" class="rounded-3 object-fit-cover" alt="">
                    @endif`);
                }
            });
            $(".update-profile").click(function() {
                event.preventDefault();
                let imageSelected = $('#image').val() !== ''; // Check if an image is selected
                let currentPassword = $('#currentpassword').val().trim();
                let newPassword = $('#password').val().trim();
                let confirmPassword = $('#password_confirmation').val().trim();

                // Clear previous error states
                $('.form-control').removeClass('is-invalid');

                let errors = {};

                // Case 1: If all fields are empty
                if (!imageSelected && !currentPassword && !newPassword && !confirmPassword) {
                    errors['image'] = 'Please select an image or fill in the password fields.';
                }

                // Case 2: If password fields are filled, validate them
                if (currentPassword || newPassword || confirmPassword) {
                    if (!currentPassword) {
                        errors['currentpassword'] = 'Current password is required when changing passwords.';
                    }
                    if (!newPassword) {
                        errors['password'] = 'New password is required.';
                    }
                    if (!confirmPassword) {
                        errors['password_confirmation'] = 'Confirm password is required.';
                    }
                    if (newPassword !== confirmPassword) {
                        errors['password_confirmation'] =
                            'New password and confirmation password do not match.';
                    }
                    if (newPassword.length < 8) {
                        errors['password'] = 'New password must be at least 8 characters long.';
                    }
                }

                // Display errors dynamically
                if (Object.keys(errors).length > 0) {
                    $.each(errors, function(key, message) {
                        toastr.error(message, {
                            timeOut: 3000
                        });
                        let inputField = $('[name="' + key + '"]');
                        inputField.addClass(
                            'is-invalid'); // Add 'is-invalid' class to the input field
                    });
                } else {
                    let type = 'POST';
                    let url = '/admin/update-profile';
                    let message = '';
                    let form = $('#passwordVerifyForm');
                    let data = new FormData(form[0]);
                    // PASSING DATA TO FUNCTION
                    $('input').removeClass('is-invalid');
                    SendAjaxRequestToServer(type, url, data, '', updatePasswordResponse, '',
                        '.update-profile');
                }


            });

            function updatePasswordResponse(response) {
                console.log(response.status);
                // SHOWING MESSAGE ACCORDING TO RESPONSE
                if (response.status == 200 || response.status == '200') {
                    location.reload();
                    toastr.success('Profile update successfully.', {
                        timeOut: 3000
                    });
                    $('#passwordVerifyForm').trigger('reset');
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
        });
    </script>
@endpush
