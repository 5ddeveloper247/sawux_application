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
                <img src="https://images.unsplash.com/photo-1543610892-0b1f7e6d8ac1?w=1900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8cHJvZmlsZXxlbnwwfHwwfHx8MA%3D%3D"
                    width="100%" height="100%" class="rounded-3" alt="">
            </div>

            <div class="col-9 ps-4 d-flex align-items-start gap-5 justify-content-between">
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
                    <div class="d-flex flex-column mb-3">
                        <small class="light-text">Date Of Birth:</small>
                        <span>08/04/2003</span>
                    </div>
                </div>

                <div>
                    <h5 class="s-text fw-normal">Address Details</h5>

                    <div class="d-flex flex-column mb-3">
                        <small class="light-text">Address:</small>
                        <span>No 123 Abc Street</span>
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <small class="light-text">City:</small>
                        <span class="text-capitalize">Florida</span>
                    </div>
                </div>

                <div>
                    <h5 class="s-text fw-normal">Contact Details</h5>

                    <div class="d-flex flex-column mb-3">
                        <small class="light-text">Phone Number:</small>
                        <span>12345678</span>
                    </div>
                    <div class="d-flex flex-column">
                        <small class="light-text">Email:</small>
                        <span>{{ $data->email }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="sub-bg rounded-4 p-4 mt-4 col-6">
            <div class="p-1 d-flex  justify-content-center">
                <h4 class="mb-0 m-text">RESET PASSWORD</h3>
            </div>
    
            <form id="passwordVerifyForm">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Current Password</label>
                    <input type="text" class="form-control" id="currentpassword" name="currentpassword"
                        placeholder="Current Password" maxlength="50">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">New Password</label>
                    <input type="text" class="form-control" id="password" name="password" placeholder="New Password"
                        maxlength="50">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Confirm New Password</label>
                    <input type="text" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm New Password" maxlength="50">
                </div>
                <div class="text-center">
                    <button type="button" class="btn py-1 px-4 rounded-2 m-btn w-100  text-white border-0 update-profile">Update
                        Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $(".update-profile").click(function() {
                event.preventDefault();
                let type = 'POST';
                let url = '/update-profile';
                let message = '';
                let form = $('#passwordVerifyForm');
                let data = new FormData(form[0]);
                // PASSING DATA TO FUNCTION
                $('input').removeClass('is-invalid');
                SendAjaxRequestToServer(type, url, data, '', updatePasswordResponse, '', '.update-profile');

            });

            function updatePasswordResponse(response) {
                console.log(response.status);
                // SHOWING MESSAGE ACCORDING TO RESPONSE
                if (response.status == 200 || response.status == '200') {

                    toastr.success('Password update successfully.', {
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
