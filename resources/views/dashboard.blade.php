{{--
    dd($api_settings);
--}}
@extends('layouts.admin.admin_master')

@push('css')
    <style>

    </style>
@endpush

@section('content')
    <div>
        <div class="px-3 py-4" data-page="exam">
            <div class="d-flex justify-content-between">
                <div class="txt py-4">
                    <h3 class="m-text fw-bold">Hello, Customer</h3>
                </div>
                <div>
                    <label class="mb-1">Choose Locations</label>
                    <select class="form-select" id="location_id" name="location_id" aria-label="Default select example">
                        @foreach ($locations as $location)
                            <option {{ session('location_id') == $location->id ? 'selected' : '' }}
                                value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 col-12">
                    <div class="d-flex justify-content-end">
                        <div class="m-2">
                            System Status:
                        </div>
                        <div class="m-2 checkbox-wrapper form-check form-switch pt-1 p-0" style="display: none">
                            <input class="form-check-input pointer check check-box" type="checkbox" id="myCheckbox">
                            <label class="check-btn" for="myCheckbox"></label>
                        </div>
                    </div>


                    <img class="w-100 h-100 rounded-3 opacity-100" id="imageSrc" src="" alt="image"
                        style="display: none">

                </div>
            </div>
            <div class="row mt-3" id="mainContentResult_section">
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let ajaxBackendTask = false;
        $(document).ajaxStart(function() {
            ajaxBackendTask = true;
            console.log("A backend task has started.");
        });

        $(document).ajaxStop(function() {
            ajaxBackendTask = false;
            console.log("All backend tasks have completed.");
        });
        var pageFlag = false;
        var refreshTimeInterval = '{{ @$api_settings->api_refresh_time * 1000 ?? 0 }}';

        var typeIds = [];

        $(document).on('keyup', 'input', function(e) {
            $(this).removeClass('is-invalid');
        });
        $("#location_id").change(function() {
            let name = $(this).find(":selected").text();

            if (ajaxBackendTask == false) {
                pageFlag = false;
                getDashboardPageData();
                $("#header_location_name").text(name);
            } else {
                toastr.error(
                    'Please wait while the data is loading. Once the loading is complete, you can change the location.', {
                        timeOut: 3000
                    });
                let previousValue = $(this).data('previous');
                if (previousValue !== undefined) {
                    $(this).val(previousValue);
                }
            }

        });
        $("#location_id").focus(function() {
            $(this).data('previous', $(this).val());
        });

        function apiconfiguration() {
            let location_id = $("#location_id").val();
            let type = 'POST';
            let url = '/api-configuration/data';
            let data = new FormData();
            data.append('location_id', location_id);
            SendAjaxRequestToServer(type, url, data, '', apiConfigurationDataResponse, '', '.save-data');
        }

        function apiConfigurationDataResponse(response) {
            if (response.success == true || response.success == 'true') {
                if (response.data) {
                    $("#imageSrc").show();
                    $(".checkbox-wrapper").show();
                    $("#imageSrc").attr('src', response.data.image);
                    if (response.data.status == '1') {
                        $("#myCheckbox").prop('checked', true); // Set checkbox as checked
                    } else {
                        $("#myCheckbox").prop('checked', false); // Set checkbox as unchecked
                    }
                } else {
                    $("#imageSrc").hide();
                    $("#imageSrc").attr('src', '');
                    $(".checkbox-wrapper").hide();
                    $("#myCheckbox").prop('checked', false);
                }
            }
        }
        // Function to handle checkbox change
        $("#myCheckbox").on('change', function() {
            // Set a specific value based on whether the checkbox is checked or not
            let statusValue = $(this).prop('checked') ? '1' : '0'; // 'active' if checked, 'inactive' if unchecked




            if (ajaxBackendTask == false) {
                let location_id = $("#location_id").val(); // Get the location_id

                let type = 'POST';
                let url = '/updateSystemStatus';
                let data = new FormData();
                data.append('location_id', location_id);
                data.append('status', statusValue);

                // Send the updated status to the server
                SendAjaxRequestToServer(type, url, data, '', function(response) {
                    getDashboardPageData();
                    pageFlag = false;
                    toastr.success('System Status Update Successfully', '', {
                        timeOut: 3000
                    });
                }, '', '');
            } else {
                toastr.error(
                    'Please wait while the data is loading. Once the loading is complete, you can change the system status.', {
                        timeOut: 3000
                    });
                if (statusValue == 1) {
                    $("#myCheckbox").prop('checked', false); // Set the checkbox to checked
                } else {
                    $("#myCheckbox").prop('checked', true); // Set the checkbox to unchecked
                }
            }



            // Optionally, you can send this value to the server immediately

        });

        function getDashboardPageData() {
            apiconfiguration();
            let location_id = $("#location_id").val();
            let type = 'POST';
            let url = '/getDashboardPageData';
            let message = '';
            let form = '';
            let data = new FormData();
            data.append('location_id', location_id)
            // PASSING DATA TO FUNCTION
            SendAjaxRequestToServer(type, url, data, '', getDashboardPageDataResponse, '', '');
        }

        function getDashboardPageDataResponse(response) {

            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {

                var data = response.data;

                var alltypes = data.types_list;


                if (pageFlag == false) {
                    makeDynamicParamResultListing(alltypes);
                }
            }
        }


        function makeDynamicParamResultListing(alltypes) {

            pageFlag = true;
            var html = '';
            typeIds = [];

            if (alltypes.length > 0) {
                $.each(alltypes, function(index, type) {

                    typeIds.push(type.id);

                    html += `<div class="col-md-12 mb-3">
                        <div class="border p-3 rounded-3 sub-bg">
                            <div class="col-12">
                                <h5 class="heading-1 text-capitalize fw-bolder">${type.title}&nbsp;
                                    <i class="fa fa-arrows-rotate pointer" id="refresh_${type.id}" onclick="refreshParameterValues(${type.id});" title="Refresh/Load Result"></i>
                                </h5>
                            </div>
                            <div class="row">`;

                    $.each(type.sub_types, function(index, subtype) {
                        html += `<div class="col-md-4 col-12 mb-2">
                                        <p class="sub-heading text-capitalize m-text"><b>${subtype.title}:</b></p>

                                        <ul id="parameter_list1">`;
                        $.each(subtype.parameters, function(index, param) {
                            if (param.is_switch == 1) {
                                html += `<li class="d-flex align-items-center">${param.pre_title}:&nbsp;&nbsp;&nbsp;
                                                        <span class="form-check form-switch pt-1">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="paramValue_${param.id}" disabled>
                                                        </span>
                                                        - ${param.post_title}
                                                    </li>`;
                            } else {
                                html +=
                                    `<li>${param.pre_title}: <i>[<span id="paramValue_${param.id}">værdi</span>]</i> - ${param.post_title}</li>`;

                            }
                        });
                        // if (subtype.id == 3) {
                        //     $.each(subtype.parameters, function(index, param) {
                        //         html += `<li class="d-flex align-items-center">${param.pre_title}:&nbsp;&nbsp;&nbsp;
                    //                                     <span class="form-check form-switch pt-1">
                    //                                         <input class="form-check-input" type="checkbox" role="switch" id="paramValue_${param.id}" disabled>
                    //                                     </span>
                    //                                     - ${param.post_title}
                    //                                 </li>`;
                        //     });
                        // } else {
                        //     $.each(subtype.parameters, function(index, param) {
                        //         html +=
                        //             `<li>${param.pre_title}: <i>[<span id="paramValue_${param.id}">værdi</span>]</i> - ${param.post_title}</li>`;
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
            $("#mainContentResult_section").html(html);
            refreshAllTypesSequentially();
        }

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

        function refreshParameterValues(typeId) {

            $("#refresh_" + typeId).attr('onclick', '').addClass('fa-spin');
            let location_id = $("#location_id").val();
            let type = 'POST';
            let url = '/refreshParameterValuesTypeWise';
            let message = '';
            let form = '';
            let data = new FormData();
            data.append('typeId', typeId);
            data.append('location_id', location_id);
            // PASSING DATA TO FUNCTION
            SendAjaxRequestToServer(type, url, data, '', refreshParameterValuesResponse, '', '#refresh');
        }

        function refreshParameterValuesResponse(response) {

            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {

                var typeId = response.data.type_id;
                var paramResults = response.data.paramResult_list;
                $("#refresh_" + typeId).attr('onclick', 'refreshParameterValues(' + typeId + ')').removeClass('fa-spin');

                $.each(paramResults, function(index, value) {
                    if (value.is_switch == 1) {

                        $('#paramValue_' + value.id).prop('checked', value.result == '0' ? false : true);
                    } else {
                        $('#paramValue_' + value.id).html(value.result);
                    }
                });

            } else {

                toastr.error(response.message, '', {
                    timeOut: 3000
                });
            }
        }

        function refreshAllTypesSequentially() {
            // Sequentially refresh parameters for each type
            refreshTypesRecursively(typeIds, 0);
        }

        function refreshTypesRecursively(typeIds, index) {
            if (index >= typeIds.length) {
                console.log("All types refreshed!");
                return;
            }

            let typeId = typeIds[index];
            refreshParameterValues(typeId);

            // Wait for the current refresh to complete before moving to the next
            setTimeout(() => {
                refreshTypesRecursively(typeIds, index + 1);
            }, 4000); // Adjust timeout based on expected response time
        }

        $(document).ready(function() {

            getDashboardPageData();

            if (refreshTimeInterval > 1000) {
                setInterval(() => {
                    refreshAllTypesSequentially();
                }, refreshTimeInterval);
            }

        });
    </script>
@endpush
