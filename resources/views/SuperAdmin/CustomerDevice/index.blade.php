{{--
    dd($api_settings);
--}}
@extends('layouts.super_admin.master')

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
            <div class="px-4 pt-4 pb-5 bg-white mb-3 shadow">
                <div class="d-flex justify-content-end">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Choose Customer</label>
                        <select class="form-select" id="customer_id" aria-label="Default select example">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row" id="mainContent_section">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let customer_id = $('#customer_id').val();

        getDashboardPageData(customer_id);

        $("#customer_id").change(function() {
            let customer_id = $(this).val();
            getDashboardPageData(customer_id);
        })

        function getDashboardPageData(customer_id) {

            let type = 'POST';
            let url = '/admin/customer-devices/getDashboardPageData';
            let message = '';
            let form = '';
            let data = new FormData();
            data.append('customer_id', customer_id);
            // PASSING DATA TO FUNCTION
            SendAjaxRequestToServer(type, url, data, '', getDashboardPageDataResponse, '', '');
        }

        function getDashboardPageDataResponse(response) {

            // SHOWING MESSAGE ACCORDING TO RESPONSE
            if (response.success == true || response.success == 'true') {

                var data = response.data;

                var alltypes = data.types_list;

                makeDynamicParamListing(alltypes);

            }
        }

        function makeDynamicParamListing(alltypes) {

            var html = '';
            if (alltypes.length > 0) {
                $.each(alltypes, function(index, type) {

                    html += `<div class="col-md-12 mb-3">
                        <div class="border p-1">
                            <div class="col-12">
                                <h5 class="heading-1">${type.title}&nbsp;</h5>
                            </div>
                            <div class="row">`;

                    $.each(type.sub_types, function(index, subtype) {
                        html += `<div class="col-md-4 col-12 mb-2">
                                        <p class="sub-heading"><b>${subtype.title}:</b></p>

                                        <ul id="parameter_list1">`;

                        $.each(subtype.parameters, function(index, param) {
                            if (param.is_switch == 1) {
                                html += `<li class="d-flex align-items-center">${param.pre_title}:&nbsp;&nbsp;&nbsp;
                                                            ${param.on_off_flag == '1' ? 
                                                                `<span class="form-check form-switch pt-1">
                                                                                        <input class="form-check-input pointer" type="checkbox" role="switch" id="flexSwitchCheckChecked" onclick="changeParameterValueOnOff(${param.id})" checked disabled>
                                                                                    </span>` 
                                                                : 
                                                                `<span class="form-check form-switch pt-1">
                                                                                        <input class="form-check-input pointer" type="checkbox" role="switch" id="flexSwitchCheckChecked" onclick="changeParameterValueOnOff(${param.id})" disabled>
                                                                                    </span>`}
                                                            - ${param.post_title}&nbsp;
                                                        </li>`;
                            } else {
                                html +=
                                    `<li>${param.pre_title}: <i>[<span>${param.parameter != null ? param.parameter : 'værdi'}</span>]</i> - ${param.post_title} </li>`;
                            }
                        });


                        html += `</ul>
                                    </div>`;
                    });
                    html += `</div>
                        </div>
                    </div>`;
                });
            } else {

                html += `<div style="text-align: center; font-size: 18px; font-weight: bold; color: red; margin-top: 20px;">
                            Data not found.
                        </div>`
            }
            $("#mainContent_section").html(html);
        }
    </script>
@endpush
