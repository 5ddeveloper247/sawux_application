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
                    <div class="d-flex justify-content-between">
                        <div class="txt py-4">
                            <h3>Dashboard</h3>
                        </div>
                        <div>
                            <label>Choose Locations</label>
                            <select class="form-select" id="location_id" name="location_id" aria-label="Default select example">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12">

                            <img class="w-100 h-100" id="imageSrc" src="" alt="image">

                        </div>
                    </div>
                    <div class="row" id="mainContentResult_section">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ajaxStart(function() {
            console.log("A backend task has started.");
        });

        $(document).ajaxStop(function() {
            console.log("All backend tasks have completed.");
        });
        var pageFlag = false;
        var refreshTimeInterval = '{{ @$api_settings->api_refresh_time * 1000 ?? 0 }}';

        var typeIds = [];

        $(document).on('keyup', 'input', function(e) {
            $(this).removeClass('is-invalid');
        });
        $("#location_id").change(function() {
            pageFlag = false;
            getDashboardPageData();

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
                    $("#imageSrc").attr('src', response.data.image);
                } else {
                    $("#imageSrc").hide();
                    $("#imageSrc").attr('src', '');
                }
            }
        }

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
                        <div class="border p-1">
                            <div class="col-12">
                                <h5 class="heading-1">${type.title}&nbsp;
                                    <i class="fa fa-arrows-rotate pointer" id="refresh_${type.id}" onclick="refreshParameterValues(${type.id});" title="Refresh/Load Result"></i>
                                </h5>
                            </div>
                            <div class="row">`;

                    $.each(type.sub_types, function(index, subtype) {
                        html += `<div class="col-md-4 col-12 mb-2">
                                        <p class="sub-heading"><b>${subtype.title}:</b></p>

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
