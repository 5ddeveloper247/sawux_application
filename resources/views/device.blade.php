{{--
    dd($api_settings);
--}}
@extends('layouts.admin.admin_master')

@push('css')
@endpush

@section('content')
    <div>
        <div class="px-3 py-4" data-page="exam">
            <div class="d-flex justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-primary add-device m-btn border-0">Add Device</button>
                    <button type="button" class="btn btn-secondary add-type">Add I/O</button>
                    <button type="button" class="btn btn-success add-parameter">Add Component</button>
                </div>

                <div>
                    <label>Choose Locations</label>
                    <select class="form-select" id="location_id" name="location_id" aria-label="Default select example">
                        @foreach ($locations as $location)
                            <option  {{ session('location_id') == $location->id ? 'selected' : '' }}  value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <div class="row" id="mainContentEdit_section">
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="modal fade" id="editTypeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content sub-bg">
                    <form id="editType_form">
                        <input type="hidden" id="edit_type_id" name="type_id" value="">
                        <div class="modal-header justify-content-between border-0 px-4 py-3">
                            <h5 class="modal-title text-white">Device</h5>
                            <button class="btn p-1 btn-outline-light closeModal2" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 15 15">
                                    <path fill="currentColor"
                                        d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body py-0 px-4">
                            <div class="row align-items-center">
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control" id="type_title" name="title" placeholder="" maxlenght="20">
                                    <label class="ms-2" for="device_key">Title</label>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                            <button type="button" class="btn btn-cancel btn-secondary px-4 closeModal2">Cancel</button>
                            <button type="button" class="btn btn-done px-4 m-btn border-0 text-white view-exam-matrix-main-content" id="saveType_btn"
                                onclick="updateType();">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editSubTypeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content sub-bg">
                    <form id="editSubType_form">
                        <input type="hidden" id="edit_subtype_id" name="sub_type_id" value="">
                        <div class="modal-header justify-content-between border-0 px-4 py-3">
                            <h5 class="modal-title text-white">I/O</h5>
                            <button class="btn p-1 btn-outline-light closeModal3" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 15 15">
                                    <path fill="currentColor"
                                        d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body px-4 py-0">
                            <div class="row align-items-center">
                                <div class="form-floating col-md-12 mb-3">
                                    <select class="form-select py-1" aria-label="Default select example" id="subtype_type_id"
                                        name="type_id">
                                        <option>Choose Device</option>

                                    </select>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control" id="subtype_title" name="title"
                                        placeholder="" maxlenght="20">
                                    <label class="ms-2" for="device_key">Title</label>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                            <button type="button" class="btn btn-cancel py-1 btn-secondary px-4 closeModal3">Cancel</button>
                            <button type="button" class="btn btn-done px-4 py-1 m-btn border-0 text-white view-exam-matrix-main-content"
                                id="saveSubType_btn" onclick="updateSubType();">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editParameterModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content sub-bg">
                    <form id="editParameter_form">
                        <input type="hidden" id="edit_parameter_id" name="parameter_id" value="">
                        <div class="modal-header justify-content-between border-0 px-4 py-3">
                            <h5 class="modal-title text-white">Component</h5>
                            <button class="btn p-1 btn-outline-light closeModal4" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                    viewBox="0 0 15 15">
                                    <path fill="currentColor"
                                        d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body py-0 px-4">
                            <div class="row align-items-center">
                                <div class="form-floating col-md-12 mb-3">
                                    <select class="form-select py-1" aria-label="Default select example"
                                        id="parameter_type_id" name="type_id">
                                        <option>Choose Device</option>

                                    </select>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <select class="form-select py-1" aria-label="Default select example"
                                        id="parameter_sub_type_id" name="sub_type_id">
                                        <option>Choose SubType</option>
                                    </select>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <select class="form-select py-1" aria-label="Default select example"
                                        id="parameter_is_switch" name="parameter_is_switch">
                                        <option value="0">NO</option>
                                        <option value="1">YES</option>
                                    </select>
                                    <label class="ms-2" for="parameter_is_switch">Switch</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control" id="pre_title" name="pre_title"
                                        placeholder="" maxlenght="20">
                                    <label class="ms-2" for="device_key">Pre Title</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control" id="post_title" name="post_title"
                                        placeholder="" maxlenght="20">
                                    <label class="ms-2" for="device_key">Post Title</label>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                            <button type="button" class="btn btn-cancel btn-secondary px-4 py-1 closeModal4">Cancel</button>
                            <button type="button" class="btn btn-done px-4 py-1 border-0 text-white m-btn view-exam-matrix-main-content"
                                id="saveParameter_btn" onclick="updateParameter();">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <input type="hidden" id="deleteId" />
                        <input type="hidden" id="deleteUrl" />
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        Are you sure you want to delete this item?
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger confirm-delete"
                            onclick="confirmDelete()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).on('keyup', 'input', function(e) {
            $(this).removeClass('is-invalid');
        });
        $("#location_id").change(function() {
            getDashboardPageData();
        });

        function getDashboardPageData() {
            getDevices();
            let type = 'POST';
            let url = '/getDashboardPageData';
            let message = '';
            let location_id = $("#location_id").val();
            let form = '';
            let data = new FormData();
            data.append('location_id', location_id);
            // PASSING DATA TO FUNCTION
            SendAjaxRequestToServer(type, url, data, '', getDashboardPageDataResponse, '', '');
        }

        function getDashboardPageDataResponse(response) {

            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {

                var data = response.data;

                var alltypes = data.types_list;
                makeDynamicParamEditListing(alltypes);
            }
        }


        function makeDynamicParamEditListing(alltypes) {

            var html = '';
            if (alltypes.length > 0) {
                $.each(alltypes, function(index, type) {

                    html += `<div class="col-md-12 mb-3">
                        <div class="border p-3 rounded-3 sub-bg">
                            <div class="col-12">
                                <h5 class="heading-1 text-capitalize">${type.title}&nbsp;
                                    <i class="fa-regular fa-pen-to-square pointer" onclick="editType(${type.id}, '${type.title}')"></i>
                                    <i class="fa-solid fa-trash-can ms-1 text-danger pointer"  onclick="deleteType(${type.id})"></i>
                                </h5>
                            </div>
                            <div class="row">`;

                    $.each(type.sub_types, function(index, subtype) {
                        html += `<div class="col-md-4 col-12 mb-2">
                                        <p class="sub-heading text-capitalize"><b>${subtype.title}:</b> 
                                            <i class="fa-regular fa-pen-to-square pointer" onclick="editSubType(${subtype.id}, '${subtype.title}')"></i>
                                            <i class="fa-solid fa-trash-can ms-1 text-danger pointer"  onclick="deleteSubType(${subtype.id})"></i>
                                        </p>

                                        <ul id="parameter_list1">`;

                        $.each(subtype.parameters, function(index, param) {
                            if (param.is_switch == 1) {
                                html +=
                                    `<li>${param.pre_title}: <i>[<span>ON/OFF</span>]</i> - ${param.post_title} <i class="fa-regular fa-pen-to-square pointer" onclick="editParameter(${param.id}, '${param.pre_title}', '${param.post_title}', '${param.is_switch}')"></i>
                                <i class="fa-solid fa-trash-can pointer"  onclick="deleteParameter(${param.id})"></i>
                                </li>`;
                            } else {
                                html +=
                                    `<li>${param.pre_title}: <i>[<span>værdi</span>]</i> - ${param.post_title} <i class="fa-regular fa-pen-to-square pointer" onclick="editParameter(${param.id}, '${param.pre_title}', '${param.post_title}', '${param.is_switch}')"></i>
                                        <i class="fa-solid fa-trash-can ms-1 text-danger pointer"  onclick="deleteParameter(${param.id})"></i></li>`;
                            }
                        });
                        // if (subtype.id == 3) {
                        //     $.each(subtype.parameters, function(index, param) {
                        //         html +=
                        //             `<li>${param.pre_title}: <i>[<span>ON/OFF</span>]</i> - ${param.post_title} <i class="fa fa-pencil pointer" onclick="editParameter(${param.id}, '${param.pre_title}', '${param.post_title}', '${param.is_switch}')"></i></li>`;
                        //     });
                        // } else {
                        //     $.each(subtype.parameters, function(index, param) {
                        //         html +=
                        //             `<li>${param.pre_title}: <i>[<span>værdi</span>]</i> - ${param.post_title} <i class="fa fa-pencil pointer" onclick="editParameter(${param.id}, '${param.pre_title}', '${param.post_title}', '${param.is_switch}')"></i></li>`;
                        //     });
                        // }
                        html += `</ul>
                                    </div>`;
                    });
                    html += `</div>
                        </div>
                    </div>`;
                });
            } else {
                html += `<div style="text-align: center; margin-top: 50px; color: #555; font-family: Arial, sans-serif;">
                            
                            <h4 style="font-size: 20px; font-weight: bold; margin: 10px 0;">No Data Found</h4>
                        </div>`;
            }
            $("#mainContentEdit_section").html(html);
        }


        // ------------------------------ UPDATE TYPE JS CODE ---------------------------

        $(document).on('click', '.add-device', function(e) {
            e.preventDefault();
            $("#edit_type_id").val('');
            $("#editTypeModal").modal('show');
        });

        function editType(typeId, title) {
            $("#edit_type_id").val(typeId);
            $("#type_title").val(title);

            $("#editTypeModal").modal('show');
        }

        $(document).on('click', '.closeModal2', function(e) {
            $("#edit_type_id").val('');
            $("#type_title").val('');
            $("#editTypeModal").modal('hide');
        });

        function updateType() {

            let type = 'POST';
            let url = '/updateType';
            let message = '';
            let location_id = $("#location_id").val();
            if (location_id == '') {
                toastr.error('You must select a location', '', {
                    timeOut: 3000
                });
            } else {
                let form = $('#editType_form');
                let data = new FormData(form[0]);
                data.append('location_id', location_id);
                // PASSING DATA TO FUNCTION
                $('input').removeClass('is-invalid');
                SendAjaxRequestToServer(type, url, data, '', updateTypeResponse, '', '#saveType_btn');
            }

        }

        function updateTypeResponse(response) {

            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {

                $("#edit_type_id").val('');
                $("#type_title").val('');
                $("#editTypeModal").modal('hide');

                getDashboardPageData();

                toastr.success(response.message, '', {
                    timeOut: 3000
                });

                // after add get all devices
                //     getDevices();

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

        // ===================== delete function =========================//

        function deleteType(id) {
            $("#deleteId").val(id);
            $("#deleteUrl").val('/deleteType');
            $("#deleteModal").modal('toggle');
        }

        function deleteSubType(id) {
            $("#deleteId").val(id);
            $("#deleteUrl").val('/deleteSubType');
            $("#deleteModal").modal('toggle');
        }

        function deleteParameter(id) {
            $("#deleteId").val(id);
            $("#deleteUrl").val('/deleteParameter');
            $("#deleteModal").modal('toggle');
        }

        function confirmDelete() {
            let deleteId = $("#deleteId").val();
            let deleteUrl = $("#deleteUrl").val();
            let type = 'POST';
            let url = deleteUrl;
            let data = new FormData();
            data.append('id', deleteId);
            let message = '';
            SendAjaxRequestToServer(type, url, data, '', deleteResponse, '', '.confirm-delete');
        }

        function deleteResponse(response) {


            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {
                toastr.success(response.message, '', {
                    timeOut: 3000
                });
                getDashboardPageData();
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
            $("#deleteModal").modal('toggle');
        }
        //======================== end =============================//
        // getDevices();

        function getDevices() {
            let location_id = $("#location_id").val();
            let type = 'POST';
            let url = '/getDevices';
            let message = '';
            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            let data = new FormData();
            data.append('location_id', location_id);

            SendAjaxRequestToServer(type, url, data, '', deviceResponse, '', '');
        }

        function deviceResponse(response) {

            $("#parameter_type_id").empty();
            $("#subtype_type_id").empty();
            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {

                if (response.data.length > 0) {

                    for (let i = 0; i < response.data.length; i++) {
                        if (i == 0) {
                            $("#parameter_type_id").append('<option>Choose Device</option>');
                            $("#subtype_type_id").append('<option>Choose Device</option>');
                        }
                        let option = '<option value="' + response.data[i].id + '">' + response.data[i].title + '</option>';
                        $("#parameter_type_id").append(option);
                        $("#subtype_type_id").append(option);
                    }

                } else {
                    $("#parameter_type_id").append('<option>Choose Device</option>');
                    $("#subtype_type_id").append('<option>Choose Device</option>');
                }

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
                $("#parameter_sub_type_id").append('<option>Choose Sub Type</option>');
                $("#subtype_type_id").append('<option>Choose Sub Type</option>');
                toastr.error(error, '', {
                    timeOut: 3000
                });
            }
        }

        // ------------------------------ UPDATE SUB TYPE JS CODE ---------------------------
        $(document).on('click', '.add-type', function(e) {
            e.preventDefault();
            $("#edit_subtype_id").val('');
            $("#editSubType_form").trigger('reset');
            $("#subtype_type_id").show();
            $("#editSubTypeModal").modal('show');
        });



        function editSubType(subTypeId, title) {
            $("#subtype_type_id").hide();
            $("#edit_subtype_id").val(subTypeId);
            $("#subtype_title").val(title);
            $("#editSubTypeModal").modal('show');
        }

        $(document).on('click', '.closeModal3', function(e) {
            $("#edit_subtype_id").val('');
            $("#subtype_title").val('');
            $("#editSubTypeModal").modal('hide');
        });

        function updateSubType() {

            let type = 'POST';
            let url = '/updateSubType';
            let message = '';
            let form = $('#editSubType_form');
            let data = new FormData(form[0]);
            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            SendAjaxRequestToServer(type, url, data, '', updateSubTypeResponse, '', '#saveSubType_btn');
        }

        function updateSubTypeResponse(response) {

            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {

                $("#edit_subtype_id").val('');
                $("#subtype_title").val('');
                $("#editSubTypeModal").modal('hide');

                getDashboardPageData();

                toastr.success(response.message, '', {
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

        // ------------------------------ UPDATE PARAMETER JS CODE ---------------------------

        $(document).on('change', '#parameter_type_id', function(e) {
            let id = $(this).val();
            let type = 'POST';
            let url = '/getSubTpes';
            let message = '';
            let data = new FormData();
            data.append('id', id);
            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            SendAjaxRequestToServer(type, url, data, '', subTypeResponse, '', '#parameter_type_id');
        });

        function subTypeResponse(response) {

            $("#parameter_sub_type_id").empty();
            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {

                if (response.data.length > 0) {
                    toastr.success(response.message, '', {
                        timeOut: 3000
                    });

                    for (let i = 0; i < response.data.length; i++) {
                        if (i == 0) {
                            $("#parameter_sub_type_id").append('<option>Choose Sub Type</option>');
                        }
                        let option = '<option value="' + response.data[i].id + '">' + response.data[i].title + '</option>';
                        $("#parameter_sub_type_id").append(option);
                    }

                } else {
                    $("#parameter_sub_type_id").append('<option>Choose Sub Type</option>');
                }

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
                $("#parameter_sub_type_id").append('<option>Choose Sub Type</option>');
                toastr.error(error, '', {
                    timeOut: 3000
                });
            }
        }

        $(document).on('click', '.add-parameter', function(e) {
            $("#edit_parameter_id").val('');
            $("#parameter_type_id").show();
            $("#parameter_sub_type_id").show();
            $("#parameter_sub_type_id").empty();
            $("#parameter_sub_type_id").append('<option>Choose Sub Type</option>');
            $("#editParameter_form").trigger('reset');
            $("#editParameterModal").modal('show');
        });

        function editParameter(paramId, title1, title2, is_switch) {
            $("#parameter_type_id").hide();
            $("#parameter_sub_type_id").hide();
            $("#edit_parameter_id").val(paramId);
            $("#pre_title").val(title1);
            $("#post_title").val(title2);
            $("#parameter_is_switch").val(is_switch);

            $("#editParameterModal").modal('show');
        }

        $(document).on('click', '.closeModal4', function(e) {
            $("#edit_parameter_id").val('');
            $("#pre_title").val('');
            $("#post_title").val('');
            $("#editParameterModal").modal('hide');
        });

        function updateParameter() {

            let type = 'POST';
            let url = '/updateParameter';
            let message = '';
            let form = $('#editParameter_form');
            let data = new FormData(form[0]);
            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            SendAjaxRequestToServer(type, url, data, '', updateParameterResponse, '', '#saveParameter_btn');
        }

        function updateParameterResponse(response) {

            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {

                $("#edit_parameter_id").val('');
                $("#preTitle").val('');
                $("#postTitle").val('');
                $("#editParameterModal").modal('hide');

                getDashboardPageData();

                toastr.success(response.message, '', {
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

        $(document).ready(function() {

            getDashboardPageData();

        });
    </script>
@endpush
