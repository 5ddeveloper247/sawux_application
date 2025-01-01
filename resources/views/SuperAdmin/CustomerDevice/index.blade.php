{{--
    dd($api_settings);
--}}
@extends('layouts.super_admin.master')

@push('css')
@endpush

@section('content')
    <div>
        <div class="py-4 px-3" data-page="exam">
            <div class="d-flex justify-content-start flex-wrap w-100 align-items-center gap-3 mb-3">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <select class="form-select" style="width: 12rem" id="customer_id" aria-label="Default select example">
                        <option value="0">Choose Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>


                </div>
                <div>
                    <select name="" style="min-width: 12rem" class="form-select" id="location_id">
                        <option value="0">Choose Location</option>
                    </select>
                </div>
                <div>
                    <button class="py-2 px-4 m-btn text-white border-0 rounded-2 data-load">Data load</button>
                </div>

            </div>
            <div class="row" id="mainContent_section">
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var typeIds = [];
        $("#customer_id").change(function() {
            let customer_id = $('#customer_id').val();
            let tableBody = document.querySelector('#location_id');
            tableBody.innerHTML = ''; // Clear existing rows
            let id = $(this).val();
            let type = 'POST';
            let url = '/admin/getDashBoardLocation';
            let message = '';
            let data = new FormData();
            data.append('id', id)
            SendAjaxRequestToServer(type, url, data, '', locationResponse, '', '.table-customer');

        });

        function locationResponse(response) {
            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.status == 200 || response.status == '200') {
                let selectElement = document.querySelector('#location_id');
                selectElement.innerHTML = '<option value="0" selected>Choose Location</option>'; // Clear existing options

                // Append locations to the select element
                response.locations.forEach(location => {
                    let option = document.createElement('option');
                    option.value = location.id; // Use the location ID as the value
                    option.textContent = location.name; // Use the location name as the display text
                    selectElement.appendChild(option);
                });

            } else {

                if (response.status == 402) {

                    error = response.message;

                }
                toastr.error(error, '', {
                    timeOut: 3000
                });
            }
        }

        $(".data-load").click(function() {
            let customer_id = $('#customer_id').val();
            let location_id = $('#location_id').val();
            if (customer_id == '0' || customer_id == '' || location_id == '0' || location_id == '') {

                toastr.error('You must select both a customer and a location.', {
                    timeOut: 3000
                });

            } else {
                getDashboardPageData(customer_id, location_id);
            }
        });

        function getDashboardPageData(customer_id, location_id) {

            let type = 'POST';
            let url = '/admin/customer-devices/getDashboardPageData';
            let message = '';
            let form = '';
            let data = new FormData();
            data.append('customer_id', customer_id);
            data.append('location_id', location_id);
            // PASSING DATA TO FUNCTION
            SendAjaxRequestToServer(type, url, data, '', getDashboardPageDataResponse, '', '.data-load');
        }

        function getDashboardPageDataResponse(response) {

            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {

                var data = response.data;

                var alltypes = data.types_list;

                makeDynamicParamResultListing(alltypes);

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
            $("#mainContent_section").html(html);
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
            let customer_id = $("#customer_id").val();
            let type = 'POST';
            let url = '/admin/customer-devices/refreshParameterValuesTypeWise';
            let message = '';
            let form = '';
            let data = new FormData();
            data.append('typeId', typeId);
            data.append('location_id', location_id);
            data.append('customer_id', customer_id);
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
    </script>
@endpush
