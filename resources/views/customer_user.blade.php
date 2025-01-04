@extends('layouts.admin.admin_master')

@push('css')
    <style>
        select2-container {
            z-index: 2050 !important;
            height: 200px;
            /* Ensures it appears above the Bootstrap modal */
        }

        .select2-dropdown {
            z-index: 2050 !important;
        }

        .select2-container--default .select2-selection--multiple {
            /* padding-bottom: 32px !important; */

            padding-bottom: 10px !important;
        }
    </style>
@endpush

@section('content')
    <div>
        <div class="px-3 py-4" data-page="exam">
            <form>
                <div class="counters-sec mb-4">
                    <!-- Active Users Counter -->
                    <div class="counter sub-bg p-4 rounded-4 text-start">
                        <div class="d-flex align-items-center gap-2 justify-content-between mb-3">
                            <div class="w-icon">
                                <img src="{{ asset('assets/images/active-user.png') }}" width="25" alt="">
                            </div>
                            <h2 class="mb-0 text-center" id="activeUsers">0</h2>
                        </div>
                        <h6 class="fw-semibold">Active Users</h6>
                    </div>

                    <!-- Inactive Users Counter -->
                    <div class="counter sub-bg p-4 rounded-4 text-start">
                        <div class="d-flex align-items-center gap-2 justify-content-between mb-3">
                            <div class="w-icon">
                                <img src="{{ asset('assets/images/active-user.png') }}" width="25" alt="">
                            </div>
                            <h2 class="mb-0 text-center" id="inActiveUsers">0</h2>
                        </div>
                        <h6 class="fw-semibold">In Active Users</h6>
                    </div>

                    <!-- Total Users Counter -->
                    <div class="counter sub-bg p-4 rounded-4 text-start">
                        <div class="d-flex align-items-center gap-2 justify-content-between mb-3">
                            <div class="w-icon">
                                <img src="{{ asset('assets/images/active-user.png') }}" width="25" alt="">
                            </div>
                            <h2 class="mb-0 text-center" id="totalUsers">0</h2>
                        </div>
                        <h6 class="fw-semibold">Total Users</h6>
                    </div>

                    <!-- Add User Button -->
                    <a href="#"
                        class="counter sub-bg add-sub-admin p-4 rounded-4 text-start d-flex flex-column align-items-center gap-3">
                        <img src="{{ asset('assets/images/add-user.png') }}" width="45" alt="">
                        <h6 class="text-center text-white">Add Users</h6>
                    </a>
                </div>

                <div id="products">
                    <div class="p-3 sub-bg rounded-4">
                        <div class="table-responsive" style="overflow: auto;">
                            <table id="exam-listing" style="overflow: auto; width: 100%"
                                class="listing_table table table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">NAME</th>
                                        <th scope="col">USER NAME</th>
                                        <th scope="col">EMAIL</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">ACTIONS</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- First Modal: StaticBackdrop -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content sub-bg">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="saveFormData">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">Full Name*</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Name" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">User Name*</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="User Name" maxlength="50">
                                        <small
                                            style="color: #6c757d; font-size: 0.9rem; margin-top: 0.3rem; display: block;"
                                            class="form-text">
                                            <i class="fas fa-info-circle"></i>
                                            <small class="info-text" style="display: none">
                                                Usernames must begin with a letter and may
                                                include numbers, underscores, and hyphens. Minimum length is 5
                                                characters, and maximum length is 15 characters.
                                            </small>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">Email address*</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="exampleInputEmail1" class="form-label">Select Location*</label>
                                    <select class="select2" id="locations" multiple="multiple" name="locations"
                                        style="width: 100%">
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary py-1 px-4" data-bs-dismiss="modal">Close</button>
                        <button type="button"
                            class="btn m-btn border-0 py-1 px-4 rounded-2 text-white save-data">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- First Modal: StaticBackdrop -->
        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content sub-bg">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editFormData">
                            <div class="row">
                                <input type="hidden" id="id" name="id" value="" />
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">Full Name*</label>
                                        <input type="text" class="form-control" id="ename" name="name"
                                            placeholder="Name" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">User Name*</label>
                                        <input type="text" class="form-control" id="eusername" name="username"
                                            placeholder="User Name" maxlength="50">
                                        <small
                                            style="color: #6c757d; font-size: 0.9rem; margin-top: 0.3rem; display: block;"
                                            class="form-text">
                                            <i class="fas fa-info-circle icon-2"></i>
                                            <small class="info-text-2" style="display: none">Usernames must begin with a letter and may
                                                include letters, numbers, underscores, and hyphens.
                                            </small>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">Email address*</label>
                                        <input type="email" class="form-control" id="eemail" name="email"
                                            placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="exampleInputEmail1" class="form-label">Select Location*</label>
                                    <select class="select2" id="elocations" multiple="multiple" name="locations"
                                        style="width: 100%">
                                        @foreach ($editlocations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary py-1 px-4" data-bs-dismiss="modal">Close</button>
                        <button type="button"
                            class="btn m-btn border-0 py-1 px-4 rounded-2 text-white save-data">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const infoIcon = document.querySelector('.fa-info-circle');
            const infoText = document.querySelector('.info-text');
            const infoIcon2 = document.querySelector('.icon-2');
            const infoText2 = document.querySelector('.info-text-2');

            infoIcon.addEventListener('click', function() {
                if (infoText.style.display === 'none' || infoText.style.display === '') {
                    infoText.style.display = 'block';
                } else {
                    infoText.style.display = 'none';
                }
            });

            infoIcon2.addEventListener('click', function() {
                if (infoText2.style.display === 'none' || infoText2.style.display === '') {
                    infoText2.style.display = 'block';
                } else {
                    infoText2.style.display = 'none';
                }
            });
        });


        $(document).ready(function() {

            //  $('select').selectpicker();
        });


        $(document).ready(function() {
            getCardData();

            function getCardData() {
                let type = 'POST';
                let url = '/card-customer-user';
                SendAjaxRequestToServer(type, url, '', '', cardDataResponse, '', '');

            }


            function cardDataResponse(response) {
                console.log(response.status);
                // SHOWING MESSAGE ACCORDING TO RESPONSE
                if (response.status == 200 || response.status == '200') {

                    $("#totalUsers").text(response.data.total_user);
                    $("#activeUsers").text(response.data.active_user);
                    $("#inActiveUsers").text(response.data.inactive_user);

                }
            }
            pageLoader();


            function pageLoader() {


                var table = $('#exam-listing').DataTable({
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,
                    ajax: {
                        url: "{{ route('customer.users.listAll') }}", // URL to your route
                        type: 'POST', // Specify the HTTP method as POST
                    },
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

            }
            $(".add-sub-admin").click(function() {
                $("#staticBackdrop").modal('toggle');
                $('#saveFormData').trigger('reset');
                $('#locations').val('').trigger('change');
                $("#staticBackdropLabel").text('ADD USER RECORD');
                $("#id").val('');
                $('#saveFormData').find('.is-invalid').removeClass('is-invalid');
            });

            $(".form-control").on("keyup", function() {
                $(this).removeClass('is-invalid');
            });

            // save and update the records

            $(".save-data").click(function() {


                var data;
                let locations;
                let jsonLocations;
                if ($("#id").val() == '') {

                    locations = $("#locations").val();
                    jsonLocations = JSON.stringify(locations);
                    data = new FormData($('form#saveFormData')[0]);
                } else {

                    locations = $("#elocations").val();
                    jsonLocations = JSON.stringify(locations);
                    data = new FormData($('form#editFormData')[0]);
                }
                data.append('jsonLocations', jsonLocations);
                let type = 'POST';
                let url = '/customer-users/creat';
                SendAjaxRequestToServer(type, url, data, '', saveDataResponse, '', '.save-data');

            });


            function saveDataResponse(response) {
                console.log(response.status);
                // SHOWING MESSAGE ACCORDING TO RESPONSE
                if (response.status == 200 || response.status == '200') {
                    if ($("#id").val() == '') {

                        $("#staticBackdrop").modal('hide');
                    } else {

                        $("#exampleModal").modal('hide');
                    }

                    $('form').trigger('reset');
                    pageLoader();
                    getCardData();
                    toastr.success('Record create successfully.', {
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
            // edit  the records
            $("#exam-listing").on('click', '.edit-btn', function(e) {
                e.preventDefault();
                $("#staticBackdropLabel").text('Update User Record');
                $('#saveFormData').trigger('reset');
                $('#locations').val('').trigger('change');
                $('#saveFormData').find('.is-invalid').removeClass('is-invalid');
                let id = $(this).data("id");
                $("#id").val(id);
                let type = 'POST';
                let url = '/customer-users/edit';
                let data = new FormData();
                data.append('id', id);
                SendAjaxRequestToServer(type, url, data, '', editDataResponse, '', '.save-data');
            });

            function editDataResponse(response) {
                if (response.status == 200) {

                    $('#ename').val(response.data.name);
                    $('#eusername').val(response.data.username);
                    $('#eemail').val(response.data.email);
                    let location_id = response.data.location_id;

                    // If location_id is a string that looks like an array, parse it first
                    if (typeof location_id === 'string') {
                        location_id = JSON.parse(location_id); // Parse it to get the actual array
                    }

                    console.log(location_id); // Check if location_id is now an array: ["1"]

                    // Now join the array into a comma-separated string
                    let str = location_id.join(","); // "1"

                    // Set the value to Select2 and trigger the change event
                    $('#elocations').val(str.split(",")).trigger('change');

                    $("#exampleModal").modal('toggle');

                    // $('#formDiv').removeClass('d-none');
                } else {
                    //  addRecord();
                }
            }

            // delete record

            $("#exam-listing").on('click', '.delete-btn', function(e) {
                e.preventDefault();
                let id = $(this).attr("data-id");
                let type = 'POST';
                let url = '/customer-users/delete';
                let data = new FormData();
                data.append('id', id);
                SendAjaxRequestToServer(type, url, data, '', deleteDataResponse, '', '');
            });

            function deleteDataResponse(response) {
                if (response.status == 200) {

                    toastr.success('The record has been successfully deleted.', {
                        timeOut: 3000
                    });
                    pageLoader();
                    getCardData();

                } else {

                    toastr.error('An error is being encountered.', {
                        timeOut: 3000
                    });
                }
            }
            $("#exam-listing").on('change', '.form-check-input', function(e) {
                let id = $(this).attr('id');
                let status = 0;
                if ($(this).is(':checked')) {
                    status = 1;
                } else {
                    status = 0
                }
                let type = 'POST';
                let url = '/customer-users/status';
                let data = new FormData();
                data.append('id', id);
                data.append('status', status);
                SendAjaxRequestToServer(type, url, data, '', statusResponse, '', '');
            });

            function statusResponse(response) {
                if (response.status == 200) {
                    getCardData();
                    toastr.success('Status changed successfully.', {
                        timeOut: 3000
                    });

                } else {

                    toastr.error('An error is being encountered.', {
                        timeOut: 3000
                    });
                }
            }
        });
    </script>
@endpush
