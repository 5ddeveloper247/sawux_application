@extends('layouts.admin.admin_master')

@push('css')
<style>
    .heading-1{
        color:#126DA6;
    }
    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    li{
        font-size:12px;
    }
    li span{
        color:#126DA6;
    }
    .sub-heading{
        font-size:16px;
    }
    .pointer{
        cursor:pointer;
    }
</style>
@endpush

@section('content')

<div>
    <div class="p-md-4 p-3">
        <div id="products">
            <div class="">
                <div class="d-flex txt  justify-content-between ">
                    <h5>System Status</h5>
                    <div class="d-flex">
                        <span class="pt-1"><strong>OFF</strong></span>&nbsp;&nbsp;
                        <div class="form-check form-switch pt-1">
                            <input class="form-check-input pointer" type="checkbox" role="switch" id="flexSwitchCheckChecked" disabled {{@$api_settings->system_status == '1' ? 'checked' : ''}} >
                        </div>
                        <span class="pt-1"><strong>ON</strong></span>
                    </div>
                </div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link px-md-3 active" id="nav-btn" data-bs-toggle="tab" data-bs-target="#nav-tab0" type="button" role="tab" aria-controls="nav-tab" aria-selected="true">Dashboard</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-tab0" role="tabpanel" aria-labelledby="nav-broadcast-tab" tabindex="0">
                        <nav class="pt-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> -->
                                <!-- <li class="breadcrumb-item active" aria-current="page">Dynamic Parameters</li> -->
                            </ol>
                        </nav>
                        <div class="px-4 pt-4 pb-5 bg-white mb-3 shadow">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    @if(@$api_settings->image != null && @$api_settings->image != '')
                                        <img class="w-100 h-100" src="{{@$api_settings->image}}" alt="image">
                                    @endif
                                </div>
                            </div>
                            <div class="row" id="mainContentResult_section">
                                
                            <!-- HTML SECTION FOR PARAMETERS -->
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>

var refreshTimeInterval = '{{@$api_settings->api_refresh_time * 1000 ?? 0}}';

var typeIds = [];

function getDashboardPageData(){

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
        
        makeDynamicParamResultListing(alltypes);
    }
}

function makeDynamicParamResultListing(alltypes){

    var html = '';
    typeIds = [];

    if (alltypes.length > 0) {
        $.each(alltypes, function (index, type) {

            typeIds.push(type.id);

            html += `<div class="col-md-12 mb-3">
                        <div class="border p-1">
                            <div class="col-12">
                                <h5 class="heading-1">${type.title}&nbsp;
                                    <i class="fa fa-arrows-rotate pointer" id="refresh_${type.id}" onclick="refreshParameterValues(${type.id});" title="Refresh/Load Result"></i>
                                </h5>
                            </div>
                            <div class="row">`;

                            $.each(type.sub_types, function (index, subtype) {
                                html += `<div class="col-md-4 col-12 mb-2">
                                        <p class="sub-heading"><b>${subtype.title}:</b></p>

                                        <ul id="parameter_list1">`;
                                        if(subtype.id == 3){
                                            $.each(subtype.parameters, function (index, param) {
                                                html += `<li class="d-flex align-items-center">${param.pre_title}:&nbsp;&nbsp;&nbsp;
                                                            <span class="form-check form-switch pt-1">
                                                                <input class="form-check-input" type="checkbox" role="switch" id="paramValue_${param.id}" disabled>
                                                            </span>
                                                            - ${param.post_title}
                                                        </li>`;
                                            });
                                        }else{
                                            $.each(subtype.parameters, function (index, param) {
                                                html += `<li>${param.pre_title}: <i>[<span id="paramValue_${param.id}">værdi</span>]</i> - ${param.post_title}</li>`;
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
    $("#mainContentResult_section").html(html);
    refreshAllTypesSequentially();
}

function refreshParameterValues(typeId){

    $("#refresh_"+typeId).attr('onclick', '').addClass('fa-spin');

    let type = 'POST';
    let url = '/refreshParameterValuesTypeWise';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('typeId', typeId);
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', refreshParameterValuesResponse, '', '#refresh');
}

function refreshParameterValuesResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.success == true || response.success == 'true') {

        var typeId = response.data.type_id;
        var paramResults = response.data.paramResult_list;
        $("#refresh_"+typeId).attr('onclick', 'refreshParameterValues('+typeId+')').removeClass('fa-spin');

        $.each(paramResults, function (index, value) {
            if(value.sub_type_id == 3){
                $('#paramValue_'+value.id).prop('checked', value.result == '0' ? false : true);
            }else{
                $('#paramValue_'+value.id).html(value.result);
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
    }, 1000); // Adjust timeout based on expected response time
}

$(document).ready(function () {

    getDashboardPageData();

    if(refreshTimeInterval > 1000){
        setInterval(() => {
            refreshAllTypesSequentially();
        }, refreshTimeInterval);
    }
});
</script>
@endpush