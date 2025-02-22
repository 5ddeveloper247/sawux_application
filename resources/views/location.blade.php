@extends('layouts.admin.admin_master')

@push('css')

<style>
    .accordion-button::after {
        background-image: none !important;
    }
</style>

@endpush

@section('content')
    <div>
        <div class="p-md-4 p-3" data-page="exam">
            <form>

                <div class="counters-sec mb-4">
                    <div class="counter sub-bg p-4 rounded-4 text-start">
                        <div class="d-flex align-items-center gap-2 justify-content-between mb-3">
                            <div class="w-icon">
                                <img src="{{ asset('assets/images/active-user.png') }}" width="25" alt="">
                            </div>
                            <h2 class="mb-0 text-center" id="activeUsers">0</h2>
                        </div>
                        <h6 class="fw-semibold">Active locations</h6>
                    </div>

                    <div class="counter sub-bg p-4 rounded-4 text-start">
                        <div class="d-flex align-items-center gap-2 justify-content-between mb-3">
                            <div class="w-icon">
                                <img src="{{ asset('assets/images/active-user.png') }}" width="25" alt="">
                            </div>
                            <h2 class="mb-0 text-center" id="inActiveUsers">0</h2>
                        </div>
                        <h6 class="fw-semibold">In Active Locations</h6>
                    </div>

                    <div class="counter sub-bg p-4 rounded-4 text-start">
                        <div class="d-flex align-items-center gap-2 justify-content-between mb-3">
                            <div class="w-icon">
                                <img src="{{ asset('assets/images/active-user.png') }}" width="25" alt="">
                            </div>
                            <h2 class="mb-0 text-center" id="totalUsers">0</h2>
                        </div>
                        <h6 class="fw-semibold">Total Locations</h6>
                    </div>

                    <a href="#" class="counter sub-bg add-sub-admin p-4 rounded-4 text-start d-flex flex-column align-items-center gap-3">
                        <img src="{{ asset('assets/images/add-user.png') }}" width="45" alt="">
                        <h6 class="text-center text-white">Add Location</h6>
                    </a>
                </div>



                {{-- <div class="row gx-0 gy-4 gap-4 mb-4" id="exam-counters">
                    <div class="col-3 d-flex justify-content-center gap-2 align-items-center d-card py-3 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" viewBox="0 0 27 24">
                            <path fill="#2fa992"
                                d="M24 24H0V0h18.4v2.4h-16v19.2h20v-8.8h2.4V24zM4.48 11.58l1.807-1.807l5.422 5.422l13.68-13.68L27.2 3.318L11.709 18.809z" />
                        </svg>
                        <div class="ms-3">
                            <h3 class="mb-0 text-center">
                                <span class="fw-bold fs-2" id="activeUsers">0</span>
                            </h3>
                            <small>Active locations</small>
                        </div>
                    </div>
                    <div class="col-3 d-flex justify-content-center gap-2 align-items-center d-card py-3 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" viewBox="0 0 24 24">
                            <path fill="#ff0000bd"
                                d="M8 22q-.825 0-1.412-.587T6 20v-2H4q-.825 0-1.412-.587T2 16v-2h2v2h2V8q0-.825.588-1.412T8 6h8V4h-2V2h2q.825 0 1.413.588T18 4v2h2q.825 0 1.413.588T22 8v12q0 .825-.587 1.413T20 22zm0-2h12V8H8zm-6-8V8h2v4zm0-6V4q0-.825.588-1.412T4 2h2v2H4v2zm6-2V2h4v2zm0 16V8z" />
                        </svg>
                        <div class="ms-3">
                            <h3 class="mb-0 text-center">
                                <span class="fw-bold fs-2" id="inActiveUsers">0</span>
                            </h3>
                            <small>InActive locations</small>
                        </div>
                    </div>
                    <div class="col-3 d-flex justify-content-center gap-2 align-items-center d-card py-3 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M17 22q-2.075 0-3.537-1.463T12 17t1.463-3.537T17 12t3.538 1.463T22 17t-1.463 3.538T17 22m1.675-2.625l.7-.7L17.5 16.8V14h-1v3.2zM3 21V3h6.175q.275-.875 1.075-1.437T12 1q1 0 1.788.563T14.85 3H21v8.25q-.45-.325-.95-.55T19 10.3V5h-2v3H7V5H5v14h5.3q.175.55.4 1.05t.55.95zm9-16q.425 0 .713-.288T13 4t-.288-.712T12 3t-.712.288T11 4t.288.713T12 5" />
                        </svg>
                        <div class="ms-3">
                            <h3 class="mb-0 text-center">
                                <span class="fw-bold fs-2" id="totalUsers">0</span>
                            </h3>
                            <small>Total locations</small>
                        </div>
                    </div>
                    <a href="#"
                        class="col-3 d-flex justify-content-center align-items-center d-card py-md-4 py-3 px-3 add-sub-admin">
                        <div class="d-flex flex-column align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" viewBox="0 0 32 32">
                                <path fill="currentColor"
                                    d="M16 3C8.832 3 3 8.832 3 16s5.832 13 13 13s13-5.832 13-13S23.168 3 16 3m0 2c6.087 0 11 4.913 11 11s-4.913 11-11 11S5 22.087 5 16S9.913 5 16 5m-1 5v5h-5v2h5v5h2v-5h5v-2h-5v-5z" />
                            </svg>
                            <small class="text-center">Add locations</small>
                        </div>
                    </a>
                </div> --}}


                <div id="products">
                    <div class="sub-bg p-3 rounded-4">

                        {{-- <div class="accordion border-0" id="accordionExample">
                            <div class="accordion-item bg-transparent border-0">
                                <h2 class="accordion-header border-0">
                                    <button class="accordion-button bg-transparent text-white border-0 px-0 pb-4" style="box-shadow: none" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Advance Search <i class="fa-solid fa-circle-arrow-down ps-2"></i>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse border-0"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body pt-0 px-3 pb-4">
                                        <div class="row gy-3">
                                            <div class="col-sm-6 col-md-4 col-xl-3">
                                                <label for="locationName" class="form-label text-white">Location Name</label>
                                                <input type="text" id="locationName" name="location_name"
                                                    class="form-control" placeholder="Enter Location Name">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-xl-2">
                                                <label for="code" class="form-label text-white">Code</label>
                                                <input type="text" id="code" name="code" class="form-control"
                                                    placeholder="Enter Code">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-xl-2">
                                                <label for="postalCode" class="form-label text-white">Postal Code</label>
                                                <input type="text" id="postalCode" name="postal_code"
                                                    class="form-control" placeholder="Enter Postal Code">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-xl-3">
                                                <label for="address" class="form-label text-white">Address</label>
                                                <input type="text" id="address" name="address" class="form-control"
                                                    placeholder="Enter Address">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-xl-2">
                                                <label for="status" class="form-label text-white">Status</label>
                                                <select id="status" name="status" class="form-select">
                                                    <option value="">All</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 d-flex justify-content-end mt-3">
                                                <button type="reset" id="reset-button"
                                                class="btn btn-secondary py-1 px-4">Reset</button>
                                                <button type="button" id="search-button"
                                                    class="py-1 px-4 m-btn ms-2 rounded-2 border-0">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="table-responsive" style="overflow: auto;">
                            <table id="exam-listing" style="overflow: auto; width: 100%;"
                                class="listing_table table table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">LOCATION NAME</th>
                                        <th scope="col">CODE</th>
                                        <th scope="col">POSTAL CODE</th>
                                        <th scope="col">ADDRESS</th>
                                        <th scope="col">DESCRIPTION</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content sub-bg">
                <div class="modal-header border-0">
                    <h5 class="modal-title " id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-image: none !important">
                        <i class="fa-solid fa-xmark text-white fs-5"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="saveFormData">
                        <div class="row">
                            <input type="hidden" id="id" name="id" value="" />
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Location Name*</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name" maxlength="12">
                                    <small style="color: #6c757d; font-size: 0.9rem; margin-top: 0.3rem; display: block;"
                                        class="form-text">
                                        <i class="fas fa-info-circle"></i> Location name: only 12 characters allowed.
                                    </small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Code*</label>
                                    <input type="text" class="form-control" id="code" name="code"
                                        placeholder="Code" maxlength="8">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Postal Code*</label>
                                    <input type="number" class="form-control" id="postal_code" name="postal_code"
                                        placeholder="Postal Code" maxlength="8">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Address*</label>
                                    <textarea type="text" rows="2" class="form-control" id="address" name="address" placeholder="Address"
                                        maxlength="70"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Description*</label>
                                    <textarea type="text" rows="2" class="form-control" id="description" name="description"
                                        placeholder="Description" maxlength="300"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary py-1 px-4" data-bs-dismiss="modal">Close</button>
                    <button type="button"
                        class="btn m-btn py-1 px-4 rounded-2 text-white border-0 save-data">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            getCardData();

            function getCardData() {
                let type = 'POST';
                let url = '/location/card';
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
                        url: "{{ route('locations.listAll') }}", // URL to your route
                        type: 'POST', // Specify the HTTP method as POST
                    },
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'code',
                            name: 'code'
                        },
                        {
                            data: 'postal_code',
                            name: 'postal_code'
                        },
                        {
                            data: 'address',
                            name: 'address'
                        },
                        {
                            data: 'description',
                            name: 'description'
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
                $("#staticBackdropLabel").text('Add Location');
                $("#id").val('');
                $('#saveFormData').find('.is-invalid').removeClass('is-invalid');
            });

            $(".form-control").on("keyup", function() {
                $(this).removeClass('is-invalid');
            });

            // save and update the records

            $(".save-data").click(function() {
                var data = new FormData($('form#saveFormData')[0]);

                let type = 'POST';
                let url = '/locations/creat';
                SendAjaxRequestToServer(type, url, data, '', saveDataResponse, '', '.save-data');

            });


            function saveDataResponse(response) {
                console.log(response.status);
                // SHOWING MESSAGE ACCORDING TO RESPONSE
                if (response.status == 200 || response.status == '200') {
                    $("#staticBackdrop").modal('toggle');
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
                $("#staticBackdropLabel").text('Update Location');
                $('#saveFormData').trigger('reset');
                $('#saveFormData').find('.is-invalid').removeClass('is-invalid');
                let id = $(this).data("id");
                $("#id").val(id);
                let type = 'POST';
                let url = '/locations/edit';
                let data = new FormData();
                data.append('id', id);
                SendAjaxRequestToServer(type, url, data, '', editDataResponse, '', '.save-data');
            });

            function editDataResponse(response) {
                if (response.status == 200) {

                    $('#name').val(response.data.name);
                    $('#code').val(response.data.code);
                    $('#postal_code').val(response.data.postal_code);
                    $('#description').val(response.data.description);
                    $('#address').val(response.data.address);
                    $("#staticBackdrop").modal('toggle');

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
                let url = '/locations/delete';
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
                let url = '/locations/status';
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
