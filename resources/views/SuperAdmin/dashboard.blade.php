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
                                <h6 class="mb-0 fw-semibold">Total Sub Admins</h6>
                            </div>
                            <h3 class="fw-bold">1200</h3>
                        </div>

                        <div class="counters">
                            <div class="counter sub-bg p-4 rounded-4">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="w-icon">
                                        <img src="{{ asset('assets/images/customer.png') }}" width="20" alt="">
                                    </div>
                                    <h6 class="mb-0 fw-semibold">Total Admin Customers</h6>
                                </div>
                                <h3 class="fw-bold">780</h3>
                            </div>
                        </div>

                        <div class="counters">
                            <div class="counter sub-bg p-4 rounded-4">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="w-icon">
                                        <img src="{{ asset('assets/images/customer-review.png') }}" width="20"
                                            alt="">
                                    </div>
                                    <h6 class="mb-0 fw-semibold">Total Sub Customers</h6>
                                </div>
                                <h3 class="fw-bold">360</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-5">
                        <div class="col-lg-7 col-xxl-8">
                            <div class="sub-bg p-4 rounded-4">
                                <h6 class="fw-bold">New Users</h6>
                                <span class="light-text">
                                    You have connected 40 new sub admins, admin customers and sub customers
                                </span>
                                <div id="barChart" class="text-dark"></div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-xxl-4">
                            <div class="counter sub-bg p-4 rounded-4">
                                <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                    <h6 class="fw-bold mb-0">New Admin Customers</h6>
                                    <a href="/admin/customer-admin"
                                        class="fs-14 light-text d-flex align-items-center gap-1 text-nowrap">
                                        View All
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </div>

                                <div class="overflow-y-auto new-list" style="height: 21.5rem">
                                    @for ($i = 0; $i < 5; $i++)
                                        <article class="p-2 rounded-4 d-flex align-items-center  gap-3 mb-3">
                                            <img src="{{ asset('assets/images/5.jpg') }}" width="40"
                                                style="border-radius: 50%" alt="">
                                            <div class="w-100 d-flex flex-column gap-2">
                                                {{-- <h6 class="fs-14 mb-1 fw-semibold">5D Solutions</h6> --}}
                                                <small class="light-text">
                                                    <i class="fa-solid fa-user"></i>
                                                    Shehryar Shahid
                                                </small>
                                                <small class="light-text">
                                                    <i class="fa-solid fa-building"></i>
                                                    5D Solutions
                                                </small>
                                                <small class="m-text fs-12">
                                                    Joined * 12/23/2024
                                                </small>
                                            </div>
                                        </article>
                                    @endfor
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mt-4 sub-bg p-3 rounded-4">

                        <div class="d-flex align-items-center justify-content-end">
                            <select class="form-select mb-3 bg-dark text-white" aria-label="Default select example">
                                <option selected>Choose a location</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                        <div class="table-responsive overflow-y-auto" style="height: 15rem;">
                            <table style="width: 100%;" class="table table-responsive">
                                <thead>
                                    <tr>

                                        <th class="fs-14 text-white" scope="col">DEVICE NAME</th>
                                        <th class="fs-14 text-white" scope="col">DEVICE TYPE</th>
                                        <th class="fs-14 text-white" scope="col">DEVICE PARMETER</th>
                                        <th class="fs-14 text-white" scope="col">DEVICE LOCATION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td>Type</td>
                                        <td>Parameter</td>
                                        <td>Location</td>
                                    </tr>

                                    <tr>
                                        <td>Name</td>
                                        <td>Type</td>
                                        <td>Parameter</td>
                                        <td>Location</td>
                                    </tr>

                                    <tr>
                                        <td>Name</td>
                                        <td>Type</td>
                                        <td>Parameter</td>
                                        <td>Location</td>
                                    </tr>

                                    <tr>
                                        <td>Name</td>
                                        <td>Type</td>
                                        <td>Parameter</td>
                                        <td>Location</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-xxl-3 d-flex flex-column flex-lg-row flex-xl-column align-items-center gap-4 justify-content-between justify-content-lg-start">
                    <div class="sub-bg p-4 rounded-4 w-100 overflow-hidden">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                            <h6 class="fw-bold mb-0">New Sub Admins</h6>
                            <a href="/admin/sub-admin" class="fs-14 light-text">
                                View All
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>

                        <div class="overflow-y-auto new-list" style="height: 25rem">
                            @for ($i = 0; $i < 5; $i++)
                                <article class="p-2 rounded-4 d-flex align-items-center gap-3 mb-3">
                                    <img src="{{ asset('assets/images/5.jpg') }}" width="40" style="border-radius: 50%"
                                        alt="">
                                    <div class="w-100 d-flex flex-column gap-2">
                                        <h6 class="fs-14 mb-0">Shehryar Shahid</h6>
                                        <small class="fw-light wrap">shehryar@gmail.com </small>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <small class="m-text fw-normal fs-12">ShehryarShahid123</small>
                                        </div>
                                    </div>
                                </article>
                            @endfor
                        </div>
                    </div>

                    <div class="sub-bg p-4 rounded-4 mt-0 mt-xl-2 w-100 overflow-hidden">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                            <h6 class="fw-bold mb-0">New Sub Customers</h6>
                            <a href="/admin/sub-admin" class="fs-14 light-text">
                                View All
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>

                        <div class="overflow-y-auto new-list" style="height: 25rem">
                            @for ($i = 0; $i < 5; $i++)
                                <article class="p-2 rounded-4 d-flex align-items-center  gap-3 mb-3">
                                    <img src="{{ asset('assets/images/5.jpg') }}" width="40"
                                        style="border-radius: 50%" alt="">
                                    <div class="w-100 d-flex flex-column gap-2">
                                        {{-- <h6 class="fs-14 mb-1 fw-semibold">5D Solutions</h6> --}}
                                        <small class="light-text">
                                            <i class="fa-solid fa-user"></i>
                                            Shehryar Shahid
                                        </small>

                                        <small class="light-text">
                                            <i class="fa-solid fa-building"></i>
                                            5D Solutions
                                        </small>

                                        <small class="m-text fs-12">
                                            Established * 12/23/2024
                                        </small>
                                    </div>
                                </article>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


<script>
    document.addEventListener("DOMContentLoaded", function() {


        var chartElement = document.querySelector("#barChart");

        if (chartElement) {
            var options = {
                chart: {
                    type: 'bar',
                    height: 280
                },
                series: [{
                    data: [120, 100, 140, 90, 150, 130, 110, 120, 140, 100, 110, 130]
                }],

                xaxis: {
                    categories: ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
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
                        columnWidth: '30%',
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
    });
</script>
