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
                            <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                        @endforeach
                    </select>

                    <select name="" style="width: 12rem" class="form-select" id="">
                        <option value="">Choose Location</option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
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
        let customer_id = $('#customer_id').val();



        $(".data-load").click(function() {
            let customer_id = $('#customer_id').val();
            getDashboardPageData(customer_id);
        });

        function getDashboardPageData(customer_id) {

            let type = 'POST';
            let url = '/admin/customer-devices/getDashboardPageData';
            let message = '';
            let form = '';
            let data = new FormData();
            data.append('customer_id', customer_id);
            // PASSING DATA TO FUNCTION
            SendAjaxRequestToServer(type, url, data, '', getDashboardPageDataResponse, '', '.data-load');
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
                        <div class="border p-3 rounded-3 sub-bg">
                            <div class="col-12">
                                <h5 class="heading-1 text-capitalize fw-bolder pb-3 mb-0">${type.title}&nbsp;</h5>
                            </div>
                            <div class="row gy-4">`;

                    $.each(type.sub_types, function(index, subtype) {
                        html += `<div class="col-md-4 col-12">
                                        <p class="sub-heading m-text mb-1"><b>${subtype.title}:</b></p>

                                        <ul id="parameter_list1">`;

                        $.each(subtype.parameters, function(index, param) {
                            if (param.is_switch == 1) {
                                html += `<li class="d-flex align-items-center light-text">${param.pre_title}:&nbsp;&nbsp;&nbsp;
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
                                    `<li class="light-text">${param.pre_title}: <i>[<span>${param.parameter != null ? param.parameter : 'værdi'}</span>]</i> - ${param.post_title} </li>`;
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
                html += `<div style="text-align: center; margin-top: 50px; color: #555; font-family: Arial, sans-serif;">
                            
                            <h4 style="font-size: 20px; font-weight: bold; margin: 10px 0;">No Data Found</h4>
                        </div>`;

            }
            $("#mainContent_section").html(html);
        }
    </script>
@endpush
