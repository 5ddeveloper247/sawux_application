{{--
    dd($api_settings);
--}}
@extends('layouts.super_admin.master')

@push('css')
@endpush

@section('content')
    <section class="admin_dashboard px-3 py-4">
        <div>
            <div class="row gy-4">
                <div class="col-xl-8 col-xxl-9">

                    <h3 class="m-text mb-4">Hello, Super Admin</h3>

                    <div class="counters mb-4">
                        <div class="counter sub-bg p-4 rounded-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="w-icon">
                                    <img src="{{ asset('assets/images/user-gear.png') }}" width="20" alt="">
                                </div>
                                <h6 class="mb-0 fw-semibold">Total Devices</h6>
                            </div>
                            <h3 class="fw-bold">{{ $data['total_devices'] }}</h3>
                        </div>

                        <div class="counters">
                            <div class="counter sub-bg p-4 rounded-4">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="w-icon">
                                        <img src="{{ asset('assets/images/customer.png') }}" width="20" alt="">
                                    </div>
                                    <h6 class="mb-0 fw-semibold">Total Customers</h6>
                                </div>
                                <h3 class="fw-bold">{{ $data['total_customer'] }}</h3>
                            </div>
                        </div>

                        <div class="counters">
                            <div class="counter sub-bg p-4 rounded-4">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="w-icon">
                                        <img src="{{ asset('assets/images/customer-review.png') }}" width="20"
                                            alt="">
                                    </div>
                                    <h6 class="mb-0 fw-semibold">Total Customer Users</h6>
                                </div>
                                <h3 class="fw-bold">{{ $data['total_customer_user'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-5">
                        <div class="col-lg-7 col-xxl-8">
                            <div class="sub-bg p-4 rounded-4">
                                <h6 class="fw-bold">Total Devices</h6>
                                <span class="light-text">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <select class="form-select mb-3 bg-dark text-white chart-customer"
                                            aria-label="Default select example">
                                            @foreach ($data['customers'] as $customers)
                                                <option value="{{ $customers->id }}">{{ $customers->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </span>
                                <div id="barChart" class="text-dark"></div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-xxl-4">
                            <div class="counter sub-bg p-4 rounded-4">
                                <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                    <h6 class="fw-bold mb-0">Audit Trail</h6>
                                    <a href="/admin/audit-trails"
                                        class="fs-14 light-text d-flex align-items-center gap-1 text-nowrap">
                                        View All
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </div>

                                <div class="overflow-y-auto new-list" style="height: 21.5rem">
                                    @foreach ($data['audit_trail_list'] as $audit_trail_list)
                                        <article class="p-2 rounded-4 d-flex align-items-center  gap-3 mb-3">
                                            <div class="w-100 d-flex flex-column gap-2">
                                                {{-- <h6 class="fs-14 mb-1 fw-semibold">5D Solutions</h6> --}}
                                                <small class="light-text">
                                                    <i class="fa-solid fa-home"></i>
                                                    {{ $audit_trail_list->module }}
                                                </small>
                                                <small class="light-text">
                                                    <i class="fa-solid fa-message"></i>
                                                    {{ $audit_trail_list->short_message }}
                                                </small>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mt-4 sub-bg p-3 rounded-4">

                        <div class="d-flex align-items-center justify-content-start">
                            <div class="m-2">
                                <select class="form-select mb-3 bg-dark text-white table-customer"
                                    aria-label="Default select example">
                                    <option value="0">Choose a Customer</option>
                                    @foreach ($data['customers'] as $customers)
                                        <option value="{{ $customers->id }}">{{ $customers->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="m-2">
                                <select class="form-select mb-3 bg-dark text-white table-location"
                                    aria-label="Default select example">
                                    <option selected>Choose Location</option>
                                </select>
                            </div>
                            <div class="m-2">
                                <select class="form-select mb-3 bg-dark text-white table-device"
                                    aria-label="Default select example">
                                    <option selected>Choose Device</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive overflow-y-auto" style="height: 15rem;">
                            <table style="width: 100%;" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th class="fs-14 text-white" scope="col">PRE TITLE</th>
                                        <th class="fs-14 text-white" scope="col">POST TITLE</th>
                                        <th class="fs-14 text-white" scope="col">PARAMETERS</th>
                                    </tr>
                                </thead>
                                <tbody id="parameterList">
                                    <!-- Dynamically populated rows will go here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div
                    class="col-xl-4 col-xxl-3 d-flex flex-column flex-lg-row flex-xl-column align-items-center gap-4 justify-content-between justify-content-lg-start">
                    <div class="sub-bg p-4 rounded-4 w-100 overflow-hidden">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                            <h6 class="fw-bold mb-0">New Sub Admins</h6>
                            <a href="/admin/sub-admin" class="fs-14 light-text">
                                View All
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>

                        <div class="overflow-y-auto new-list" style="height: 25rem">
                            @foreach ($data['sub_admin_list'] as $sub_admin)
                                <article class="p-2 rounded-4 d-flex align-items-center gap-3 mb-3">
                                    <img src="{{ asset('assets/images/5.jpg') }}" width="40" style="border-radius: 50%"
                                        alt="">
                                    <div class="w-100 d-flex flex-column gap-2">
                                        <h6 class="fs-14 mb-0">{{ $sub_admin->username }}</h6>
                                        <small class="fw-light wrap">{{ $sub_admin->email }}</small>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <small class="m-text fw-normal fs-12">{{ $sub_admin->email }}</small>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>

                    <div class="sub-bg p-4 rounded-4 mt-0 mt-xl-2 w-100 overflow-hidden">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                            <h6 class="fw-bold mb-0">New Customers</h6>
                            <a href="/admin/customers" class="fs-14 light-text">
                                View All
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>

                        <div class="overflow-y-auto new-list" style="height: 25rem">
                            @foreach ($data['customer_list'] as $customer)
                                <article class="p-2 rounded-4 d-flex align-items-center  gap-3 mb-3">
                                    <img src="{{ asset('assets/images/5.jpg') }}" width="40"
                                        style="border-radius: 50%" alt="">
                                    <div class="w-100 d-flex flex-column gap-2">
                                        {{-- <h6 class="fs-14 mb-1 fw-semibold">5D Solutions</h6> --}}
                                        <small class="light-text">
                                            <i class="fa-solid fa-user"></i>
                                            {{ $customer->name }}
                                        </small>

                                        <small class="light-text">
                                            <i class="fa-solid fa-building"></i>
                                            {{ $customer->address }}
                                        </small>

                                        <small class="m-text fs-12">
                                            Established * {{ $customer->establish_date }}
                                        </small>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            function initializeChart(categories, seriesData) {
                var chartElement = document.querySelector("#barChart");

                if (chartElement) {
                    var options = {
                        chart: {
                            type: 'bar',
                            height: 280
                        },
                        series: [{
                            data: seriesData // Use the response data here
                        }],
                        xaxis: {
                            categories: categories, // Set categories dynamically
                            labels: {
                                style: {
                                    colors: '#fff',
                                    fontSize: '12px'
                                }
                            },
                            axisBorder: {
                                color: '#fff'
                            },
                            axisTicks: {
                                color: '#fff'
                            }
                        },
                        yaxis: {
                            title: {
                                style: {
                                    color: '#fff'
                                }
                            },
                            labels: {
                                style: {
                                    colors: '#fff'
                                }
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '10rem',
                                borderRadius: 50,
                            }
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'light',
                                type: 'vertical',
                                shadeIntensity: 0.5,
                                gradientToColors: ['#008006'],
                                inverseColors: true,
                                opacityFrom: 1,
                                opacityTo: 0.75,
                                stops: [0, 100]
                            }
                        },
                        colors: ['#c2ff00'],
                    };

                    // Create and render the bar chart
                    var chart = new ApexCharts(chartElement, options);
                    chart.render();
                } else {
                    console.error("Element with id 'barChart' not found.");
                }
            }

            // Call the chart initially with default data

            getData();

            $(".chart-customer").change(function() {
                getData();

            });


            function getData() {
                let id = $(".chart-customer").val();
                let type = 'POST';
                let url = '/admin/getDashBoardChart';
                let message = '';
                let data = new FormData();
                data.append('id', id)
                SendAjaxRequestToServer(type, url, data, '', chartResponse, '','.chart-customer');
            }

            function chartResponse(response) {
                console.log(response.status);
                // SHOWING MESSAGE ACCORDING TO RESPONSE
                if (response.status == 200 || response.status == '200') {
                    initializeChart(response.locations, response.device_counts);
                } else {

                    if (response.status == 402) {

                        error = response.message;

                    }
                    toastr.error(error, '', {
                        timeOut: 3000
                    });
                }
            }
            // datatable data

            $(".table-customer").change(function() {
                let tableBody = document.querySelector('#parameterList');
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
                    let selectElement = document.querySelector('.table-location');
                    selectElement.innerHTML = '<option selected>Choose Location</option>'; // Clear existing options

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


            $(".table-location").change(function() {
                let tableBody = document.querySelector('#parameterList');
                tableBody.innerHTML = ''; // Clear existing rows
                let id = $(this).val();
                let type = 'POST';
                let url = '/admin/getDashBoardDevice';
                let message = '';
                let data = new FormData();
                data.append('id', id)
                SendAjaxRequestToServer(type, url, data, '', deviceResponse, '', '.table-location');
            });

            function deviceResponse(response) {
                // SHOWING MESSAGE ACCORDING TO RESPONSE
                if (response.status == 200 || response.status == '200') {
                    let selectElement = document.querySelector('.table-device');
                    selectElement.innerHTML = '<option selected>Choose Device</option>'; // Clear existing options

                    // Append locations to the select element
                    response.devices.forEach(location => {
                        let option = document.createElement('option');
                        option.value = location.id; // Use the location ID as the value
                        option.textContent = location.title; // Use the location name as the display text
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

            $(".table-device").change(function() {
                let id = $(this).val();
                let type = 'POST';
                let url = '/admin/getDashBoardParameterList';
                let message = '';
                let data = new FormData();
                data.append('id', id)
                SendAjaxRequestToServer(type, url, data, '', parameterResponse, '', '.table-device');
            });

            function parameterResponse(response) {
                if (response.status == 200 || response.status == '200') {
                    let tableBody = document.querySelector('#parameterList');
                    tableBody.innerHTML = ''; // Clear existing rows

                    response.devices.forEach(device => {
                        // Add a row for the SubType
                        let subTypeRow = `
                <tr>
                    <td colspan="3" class="fs-14 text-white">
                        <strong>${device.title}</strong> <!-- SubType Title -->
                    </td>
                </tr>
            `;
                        tableBody.innerHTML += subTypeRow;

                        // Add rows for DynamicParameters under the SubType
                        if (device.parameters.length > 0) {
                            device.parameters.forEach(parameter => {
                                let parameterRow = `
                        <tr>
                            <td>${parameter.pre_title}</td>
                            <td>${parameter.post_title}</td>
                            <td>${parameter.parameter}</td>
                        </tr>
                    `;
                                tableBody.innerHTML += parameterRow;
                            });
                        } else {
                            let noParameterRow = `
                    <tr>
                        <td colspan="3" class="text-center">No Parameters Available</td>
                    </tr>
                `;
                            tableBody.innerHTML += noParameterRow;
                        }
                    });
                } else {
                    let error = response.message || 'An error occurred';
                    toastr.error(error, '', {
                        timeOut: 3000
                    });
                    let tableBody = document.querySelector('#parameterList');
                    tableBody.innerHTML = ''; // Clear existing rows
                }
            }
        });
    </script>
@endpush
