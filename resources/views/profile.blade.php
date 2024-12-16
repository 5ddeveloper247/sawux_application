{{--
    dd($api_settings);
--}}
@extends('layouts.admin.admin_master')

@push('css')
    <style>
        .heading-1 {
            color: #126DA6;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            font-size: 12px;
        }

        li span {
            color: #126DA6;
        }

        .sub-heading {
            font-size: 16px;
        }

        .pointer {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="container py-3">
        <!-- User Profile Section -->
        <div class="container py-3">
            <div class="row g-4 justify-content-center">

                <!-- Change Password Section -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header text-center bg-primary text-white rounded-top-4">
                            <h4 class="mb-0">USER INFORMATION</h4>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Name:</strong>
                                    <span>{{ $data->name }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Username:</strong>
                                    <span>{{ $data->username }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Email:</strong>
                                    <span>{{ $data->email }}</span>
                                </li>

                            </ul>
                            <div class="p-1 d-flex  justify-content-center">
                                <h4 class="mb-0 ">RESET PASSWORD</h3>
                            </div>
                            <form id="passwordVerifyForm">
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
                                        class="btn btn-primary btn-lg w-100 shadow-sm update-profile">Update
                                        Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
