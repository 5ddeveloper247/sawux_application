{{--
    dd($api_settings);
--}}
@extends('layouts.admin.admin_master')

@push('css')
@endpush

@section('content')
    <div class="px-3 py-4">
        <h3 class="m-text fw-semibold">Profile</h3>

        <div class="row g-0 align-items-start sub-bg rounded-4 p-4">
            <div class="col-2">
                @if ($data->profile)
                    <img src="{{ url($data->profile) }}" width="100%" height="220px" style="object-fit: contain"
                        class="rounded-3" alt="">
                @else
                    <img src="https://images.unsplash.com/photo-1543610892-0b1f7e6d8ac1?w=1900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8cHJvZmlsZXxlbnwwfHwwfHx8MA%3D%3D"
                        width="100%" height="220" class="rounded-3 object-fit-cover" alt="">
                @endif

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
                        <h5 class="mb-0 m-text">RESET PASSWORD</h5>
                    </div>

                    <form id="passwordVerifyForm">
                        <label class="ms-2" for="">Profile Image</label>
                        <div class="form-floating  col-12 mb-3">

                            <input type="file" class="form-control" id="image" name="image" accept="image/*" single
                                placeholder="" value="">

                        </div>
                        <div class="form-floating  col-12 mb-3" id="previewImage">


                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Current Password</label>
                            <input type="text" class="form-control" id="currentpassword" name="currentpassword"
                                placeholder="Current Password" maxlength="50">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">New Password</label>
                            <input type="text" class="form-control" id="password" name="password"
                                placeholder="New Password" maxlength="50">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Confirm New Password</label>
                            <input type="text" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm New Password" maxlength="50">
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
        $(document).ready(function() {
            $('#image').on('change', function() {
                const file = this.files[0]; // Get the selected file
                const preview = $('#previewImage'); // Image preview element

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.html(
                            `<img class="w-50 h-50" src="${e.target.result}" alt="image">`
                        );
                    };

                    reader.readAsDataURL(file); // Read the file as a data URL
                } else {
                    preview.html(`<p>No Image Uploaded</p>`);
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
                    @if (@Auth::user()->role == '2')
                    let url = '/update-profile';
                    @else
                    let url = '/customer/update-profile';
                    @endif
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

                    toastr.success('Profile update successfully.', {
                        timeOut: 3000
                    });
                    location.reload();
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
