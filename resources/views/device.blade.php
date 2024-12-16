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
    <div>
        <div class="p-md-4 p-3" data-page="exam">
            <div id="products">
                <div class="px-4 pt-4 pb-5 bg-white mb-3 shadow">
                    <div class="row" id="mainContentEdit_section">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>


        <div class="modal fade" id="deviceKeyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content border">
                    <form id="addDeviceKey_form">
                        <input type="hidden" id="type_id" name="type_id" value="">
                        <div class="modal-header justify-content-between border-0 px-4 py-3">
                            <h5 class="modal-title text-white">Device Key Details</h5>
                            <button class="btn p-1 btn-outline-light closeModal1" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                    viewBox="0 0 15 15">
                                    <path fill="currentColor"
                                        d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body pt-4 pb-2 px-4">
                            <div class="row align-items-center">
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control" id="device_key" name="device_key"
                                        placeholder="Title" maxlenght="200">
                                    <label class="ms-2" for="device_key">Device Key</label>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center px-4 pb-4 pt-3">
                            <button type="button" class="btn btn-cancel px-4 closeModal1">Cancel</button>
                            <button type="button" class="btn btn-done px-4 view-exam-matrix-main-content"
                                id="saveDeviceKey_btn" onclick="saveDeviceKeyValue();">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editTypeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content border">
                    <form id="editType_form">
                        <input type="hidden" id="edit_type_id" name="type_id" value="">
                        <div class="modal-header justify-content-between border-0 px-4 py-3">
                            <h5 class="modal-title text-white">Type Details</h5>
                            <button class="btn p-1 btn-outline-light closeModal2" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                    viewBox="0 0 15 15">
                                    <path fill="currentColor"
                                        d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body pt-4 pb-2 px-4">
                            <div class="row align-items-center">
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control" id="type_title" name="title"
                                        placeholder="Title" maxlenght="20">
                                    <label class="ms-2" for="device_key">Title</label>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center px-4 pb-4 pt-3">
                            <button type="button" class="btn btn-cancel px-4 closeModal2">Cancel</button>
                            <button type="button" class="btn btn-done px-4 view-exam-matrix-main-content"
                                id="saveType_btn" onclick="updateType();">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editSubTypeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content border">
                    <form id="editSubType_form">
                        <input type="hidden" id="edit_subtype_id" name="sub_type_id" value="">
                        <div class="modal-header justify-content-between border-0 px-4 py-3">
                            <h5 class="modal-title text-white">Sub Type Details</h5>
                            <button class="btn p-1 btn-outline-light closeModal3" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                    viewBox="0 0 15 15">
                                    <path fill="currentColor"
                                        d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body pt-4 pb-2 px-4">
                            <div class="row align-items-center">
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control" id="subtype_title" name="title"
                                        placeholder="Title" maxlenght="20">
                                    <label class="ms-2" for="device_key">Title</label>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center px-4 pb-4 pt-3">
                            <button type="button" class="btn btn-cancel px-4 closeModal3">Cancel</button>
                            <button type="button" class="btn btn-done px-4 view-exam-matrix-main-content"
                                id="saveSubType_btn" onclick="updateSubType();">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editParameterModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content border">
                    <form id="editParameter_form">
                        <input type="hidden" id="edit_parameter_id" name="parameter_id" value="">
                        <div class="modal-header justify-content-between border-0 px-4 py-3">
                            <h5 class="modal-title text-white">Parameter Details</h5>
                            <button class="btn p-1 btn-outline-light closeModal4" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                    viewBox="0 0 15 15">
                                    <path fill="currentColor"
                                        d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body pt-4 pb-2 px-4">
                            <div class="row align-items-center">
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control" id="pre_title" name="pre_title"
                                        placeholder="Pre Title" maxlenght="20">
                                    <label class="ms-2" for="device_key">Pre Title</label>
                                </div>
                                <div class="form-floating col-md-12 mb-3">
                                    <input type="text" class="form-control" id="post_title" name="post_title"
                                        placeholder="Post Title" maxlenght="20">
                                    <label class="ms-2" for="device_key">Post Title</label>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center px-4 pb-4 pt-3">
                            <button type="button" class="btn btn-cancel px-4 closeModal4">Cancel</button>
                            <button type="button" class="btn btn-done px-4 view-exam-matrix-main-content"
                                id="saveParameter_btn" onclick="updateParameter();">Save</button>
                        </div>
                    </form>
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

        function getDashboardPageData() {

            let type = 'POST';
            let url = '/getDashboardPageData';
            let message = '';
            let form = '';
            let data = new FormData();
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
                        <div class="border p-1">
                            <div class="col-12">
                                <h5 class="heading-1">${type.title}&nbsp;
                                    <i class="fa fa-pencil pointer" onclick="editType(${type.id}, '${type.title}')"></i>
                                </h5>
                            </div>
                            <div class="row">`;

                    $.each(type.sub_types, function(index, subtype) {
                        html += `<div class="col-md-4 col-12 mb-2">
                                        <p class="sub-heading"><b>${subtype.title}:</b> <i class="fa fa-pencil pointer" onclick="editSubType(${subtype.id}, '${subtype.title}')"></i></p>

                                        <ul id="parameter_list1">`;
                        if (subtype.id == 3) {
                            $.each(subtype.parameters, function(index, param) {
                                html +=
                                    `<li>${param.pre_title}: <i>[<span>ON/OFF</span>]</i> - ${param.post_title} <i class="fa fa-pencil pointer" onclick="editParameter(${param.id}, '${param.pre_title}', '${param.post_title}')"></i></li>`;
                            });
                        } else {
                            $.each(subtype.parameters, function(index, param) {
                                html +=
                                    `<li>${param.pre_title}: <i>[<span>værdi</span>]</i> - ${param.post_title} <i class="fa fa-pencil pointer" onclick="editParameter(${param.id}, '${param.pre_title}', '${param.post_title}')"></i></li>`;
                            });
                        }
                        html += `</ul>
                                    </div>`;
                    });
                    html += `</div>
                        </div>
                    </div>`;
                });
            }
            $("#mainContentEdit_section").html(html);
        }

       

        function addParameterValue(id, parameter, parameterId) {
            $("#param_id").val(id);
            $("#parameter").val(parameter);
            $("#parameter_id").val(parameterId);
            $("#parameterModal").modal('show');
        }

        $(document).on('click', '.closeModal', function(e) {

            $("#param_id").val('');
            $("#parameter").val('');
            $("#parameter_id").val('');
            $("#parameterModal").modal('hide');
        });

        

        function changeParameterValueOnOff(id) {

            let type = 'POST';
            let url = '/changeParameterValueOnOff';
            let message = '';
            let form = '';
            let data = new FormData();
            data.append('param_id', id);
            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            SendAjaxRequestToServer(type, url, data, '', changeParameterValueOnOffResponse, '', '');
        }

        function changeParameterValueOnOffResponse(response) {

            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {
                toastr.success(response.message, '', {
                    timeOut: 3000
                });
            } else {
                toastr.error(response.message, '', {
                    timeOut: 3000
                });
            }
        }

        function addDeviceKeyValue(id, deviceKey) {
            $("#type_id").val(id);
            $("#device_key").val(deviceKey);
            $("#deviceKeyModal").modal('show');
        }

        $(document).on('click', '.closeModal1', function(e) {
            $("#type_id").val('');
            $("#device_key").val('');
            $("#deviceKeyModal").modal('hide');
        });

        // ------------------------------ UPDATE TYPE JS CODE ---------------------------
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
            let form = $('#editType_form');
            let data = new FormData(form[0]);
            // PASSING DATA TO FUNCTION
            $('input').removeClass('is-invalid');
            SendAjaxRequestToServer(type, url, data, '', updateTypeResponse, '', '#saveType_btn');
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

        // ------------------------------ UPDATE SUB TYPE JS CODE ---------------------------
        function editSubType(subTypeId, title) {
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
        function editParameter(paramId, title1, title2) {
            $("#edit_parameter_id").val(paramId);
            $("#pre_title").val(title1);
            $("#post_title").val(title2);

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
