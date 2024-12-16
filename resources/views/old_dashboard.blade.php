{{--
    dd($api_settings);
--}}
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
                            <input class="form-check-input pointer" type="checkbox" role="switch" id="flexSwitchCheckChecked" onclick="updateSystemStatus();" {{@$api_settings->system_status == '1' ? 'checked' : ''}}>
                        </div>
                        <span class="pt-1"><strong>ON</strong></span>
                    </div>
                </div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link px-md-3 active" id="nav-btn" data-bs-toggle="tab" data-bs-target="#nav-tab0" type="button" role="tab" aria-controls="nav-tab" aria-selected="true">Dashboard</button>
                        <button class="nav-link px-md-3" id="nav-btn1" data-bs-toggle="tab" data-bs-target="#nav-tab1" type="button" role="tab" aria-controls="nav-tab1" aria-selected="false">API Configuration</button>
                        <button class="nav-link px-md-3" id="nav-btn2" data-bs-toggle="tab" data-bs-target="#nav-tab2" type="button" role="tab" aria-controls="nav-tab2" aria-selected="false">Parameters</button>
                        <button class="nav-link px-md-3" id="nav-btn3" data-bs-toggle="tab" data-bs-target="#nav-tab3" type="button" role="tab" aria-controls="nav-tab3" aria-selected="false">Devices</button>
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
                    <div class="tab-pane fade" id="nav-tab1" role="tabpanel" aria-labelledby="nav-newsletter-tab" tabindex="0">
                        <div id="products">
                            
                            <nav class="pt-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <!-- <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Configuration</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">API</li> -->
                                </ol>
                            </nav>
                            <div class="px-4 pt-4 pb-5 bg-white mb-3 shadow">
                                <div class="txt py-4">
                                    <h3>API DETAILS</h3>
                                </div>
                                <form id="apiSettings_form">
                                    @csrf
                                    <div class="row">
                                        <div class="form-floating col-md-6 col-12 mb-3">
                                            <input type="url" class="form-control" id="api_url" name="api_url" placeholder="API URL" value="{{@$api_settings->api_url}}" maxlenght="200" required>
                                            <label class="mx-2" for="api_url">API URL</label>
                                        </div>
                                        <div class="form-floating col-md-6 col-12 mb-3">
                                            <input type="url" class="form-control" id="system_api_url" name="system_api_url" placeholder="System API URL" value="{{@$api_settings->system_api_url}}" maxlenght="200" required>
                                            <label class="mx-2" for="system_api_url">System API URL</label>
                                        </div>
                                        <div class="form-floating col-md-6 mb-3 d-none">
                                            <input type="text" class="form-control" id="api_key" name="api_key" maxlength="100" placeholder="API KEY" value="{{@$api_settings->api_key}}" maxlenght="200" required>
                                            <label class="mx-2" for="api_key">API KEY</label>
                                        </div>
                                        <div class="form-floating col-md-6 col-12 mb-3">
                                            <input type="number" class="form-control" id="api_refresh_time" name="api_refresh_time" 
                                                    placeholder="API Refresh Time" value="{{@$api_settings->api_refresh_time}}" 
                                                    maxlenght="10" required>
                                            <label class="mx-2" for="api_refresh_time">API Refresh Time (Seconds)</label>
                                        </div>
                                        
                                        <div class="col-md-6 col-12"></div>
                                        
                                        <div class="form-floating col-md-6 col-12 mb-3">
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*" single placeholder="" value="">
                                            <label class="mx-2" for="">Circuit Image</label>
                                        </div>
                                        <div class="form-floating col-md-6 col-12 mb-3" id="previewImage">
                                            @if(@$api_settings->image != null)
                                                <img class="w-100 h-100" src="{{@$api_settings->image}}" alt="image">
                                            @else
                                                <p>No Image Uploaded</p>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-2">
                                        <button type="button" class="btn theme-btn-outline my-4 d-flex align-items-center px-md-5 mx-1" id="saveApiSettings_btn" onclick="saveApiSettings();">SAVE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-tab2" role="tabpanel" aria-labelledby="nav-broadcast-tab" tabindex="0">
                        <nav class="pt-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <!-- <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Parameters</li> -->
                            </ol>
                        </nav>
                        <div class="px-4 pt-4 pb-5 bg-white mb-3 shadow">
                            
                            <div class="row" id="mainContent_section">
                                
                            <!-- HTML SECTION FOR PARAMETERS -->
                            
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-tab3" role="tabpanel" aria-labelledby="nav-broadcast-tab" tabindex="0">
                        <nav class="pt-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <!-- <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Parameters</li> -->
                            </ol>
                        </nav>
                        <div class="px-4 pt-4 pb-5 bg-white mb-3 shadow">
                            
                            <div class="row" id="mainContentEdit_section">
                                
                            <!-- HTML EDIT SECTION FOR PARAMETERS -->
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="parameterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border">
                <form id="addparameter_form">
                    <input type="hidden" id="param_id" name="param_id" value="">
                    <div class="modal-header justify-content-between border-0 px-4 py-3">
                        <h4 class="modal-title text-white">Parameter Details</h4>
                        <button class="btn p-1 btn-outline-light closeModal" type="button" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 15 15">
                                <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body pt-4 pb-2 px-4">
                        <div class="row align-items-center">
                            <div class="form-floating col-md-12 mb-3">
                                <input type="text" class="form-control" id="parameter" name="parameter" placeholder="Title" maxlenght="200">
                                <label class="ms-2" for="parameter">Parameter</label>
                            </div>
                            <div class="form-floating col-md-12 mb-3">
                                <input type="number" class="form-control" id="parameter_id" name="parameter_id" placeholder="Title" maxlenght="100">
                                <label class="ms-2" for="parameter_id">Parameter ID</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center px-4 pb-4 pt-3">
                        <button type="button" class="btn btn-cancel px-4 closeModal">Cancel</button>
                        <button type="button" class="btn btn-done px-4 view-exam-matrix-main-content" 
                                id="saveParam_btn" onclick="saveParameterValues();">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deviceKeyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border">
                <form id="addDeviceKey_form">
                    <input type="hidden" id="type_id" name="type_id" value="">
                    <div class="modal-header justify-content-between border-0 px-4 py-3">
                        <h5 class="modal-title text-white">Device Key Details</h5>
                        <button class="btn p-1 btn-outline-light closeModal1" type="button" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 15 15">
                                <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body pt-4 pb-2 px-4">
                        <div class="row align-items-center">
                            <div class="form-floating col-md-12 mb-3">
                                <input type="text" class="form-control" id="device_key" name="device_key" placeholder="Title" maxlenght="200">
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
                        <button class="btn p-1 btn-outline-light closeModal2" type="button" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 15 15">
                                <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body pt-4 pb-2 px-4">
                        <div class="row align-items-center">
                            <div class="form-floating col-md-12 mb-3">
                                <input type="text" class="form-control" id="type_title" name="title" placeholder="Title" maxlenght="20">
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
                        <button class="btn p-1 btn-outline-light closeModal3" type="button" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 15 15">
                                <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body pt-4 pb-2 px-4">
                        <div class="row align-items-center">
                            <div class="form-floating col-md-12 mb-3">
                                <input type="text" class="form-control" id="subtype_title" name="title" placeholder="Title" maxlenght="20">
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
                        <button class="btn p-1 btn-outline-light closeModal4" type="button" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 15 15">
                                <path fill="currentColor" d="M3.64 2.27L7.5 6.13l3.84-3.84A.92.92 0 0 1 12 2a1 1 0 0 1 1 1a.9.9 0 0 1-.27.66L8.84 7.5l3.89 3.89A.9.9 0 0 1 13 12a1 1 0 0 1-1 1a.92.92 0 0 1-.69-.27L7.5 8.87l-3.85 3.85A.92.92 0 0 1 3 13a1 1 0 0 1-1-1a.9.9 0 0 1 .27-.66L6.16 7.5L2.27 3.61A.9.9 0 0 1 2 3a1 1 0 0 1 1-1c.24.003.47.1.64.27" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body pt-4 pb-2 px-4">
                        <div class="row align-items-center">
                            <div class="form-floating col-md-12 mb-3">
                                <input type="text" class="form-control" id="pre_title" name="pre_title" placeholder="Pre Title" maxlenght="20">
                                <label class="ms-2" for="device_key">Pre Title</label>
                            </div>
                            <div class="form-floating col-md-12 mb-3">
                                <input type="text" class="form-control" id="post_title" name="post_title" placeholder="Post Title" maxlenght="20">
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

var pageFlag = false;
var refreshTimeInterval = '{{@$api_settings->api_refresh_time * 1000 ?? 0}}';

var typeIds = [];

$(document).on('keyup', 'input', function (e) {
    $(this).removeClass('is-invalid');
});

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
        
        makeDynamicParamListing(alltypes);
        makeDynamicParamEditListing(alltypes);
        if(pageFlag == false){
            makeDynamicParamResultListing(alltypes);
        }
    }
}

function makeDynamicParamListing(alltypes){

    var html = '';
    if (alltypes.length > 0) {
        $.each(alltypes, function (index, type) {

            html += `<div class="col-md-12 mb-3">
                        <div class="border p-1">
                            <div class="col-12">
                                <h5 class="heading-1">${type.title}&nbsp;
                                <i class="fa fa-pencil pointer" onclick="addDeviceKeyValue(${type.id}, '${type.device_key!=null?type.device_key:''}')"></i></h5>
                            </div>
                            <div class="row">`;

                            $.each(type.sub_types, function (index, subtype) {
                                html += `<div class="col-md-4 col-12 mb-2">
                                        <p class="sub-heading"><b>${subtype.title}:</b></p>

                                        <ul id="parameter_list1">`;
                                        if(subtype.id == 3){
                                            $.each(subtype.parameters, function (index, param) {
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
                                                            <i class="fa fa-pencil pointer" onclick="addParameterValue(${param.id}, '${param.parameter!=null?param.parameter:''}', '${param.parameter_id!=null?param.parameter_id:''}')"></i>
                                                        </li>`;
                                            });
                                        }else{
                                            $.each(subtype.parameters, function (index, param) {
                                                html += `<li>${param.pre_title}: <i>[<span>${param.parameter != null ? param.parameter : 'værdi'}</span>]</i> - ${param.post_title} <i class="fa fa-pencil pointer" onclick="addParameterValue(${param.id}, '${param.parameter!=null?param.parameter:''}', '${param.parameter_id!=null?param.parameter_id:''}')"></i></li>`;
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
    $("#mainContent_section").html(html);
}

function makeDynamicParamEditListing(alltypes){

    var html = '';
    if (alltypes.length > 0) {
        $.each(alltypes, function (index, type) {

            html += `<div class="col-md-12 mb-3">
                        <div class="border p-1">
                            <div class="col-12">
                                <h5 class="heading-1">${type.title}&nbsp;
                                    <i class="fa fa-pencil pointer" onclick="editType(${type.id}, '${type.title}')"></i>
                                </h5>
                            </div>
                            <div class="row">`;

                            $.each(type.sub_types, function (index, subtype) {
                                html += `<div class="col-md-4 col-12 mb-2">
                                        <p class="sub-heading"><b>${subtype.title}:</b> <i class="fa fa-pencil pointer" onclick="editSubType(${subtype.id}, '${subtype.title}')"></i></p>

                                        <ul id="parameter_list1">`;
                                        if(subtype.id == 3){
                                            $.each(subtype.parameters, function (index, param) {
                                                html += `<li>${param.pre_title}: <i>[<span>ON/OFF</span>]</i> - ${param.post_title} <i class="fa fa-pencil pointer" onclick="editParameter(${param.id}, '${param.pre_title}', '${param.post_title}')"></i></li>`;
                                            });
                                        }else{
                                            $.each(subtype.parameters, function (index, param) {
                                                html += `<li>${param.pre_title}: <i>[<span>værdi</span>]</i> - ${param.post_title} <i class="fa fa-pencil pointer" onclick="editParameter(${param.id}, '${param.pre_title}', '${param.post_title}')"></i></li>`;
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

function makeDynamicParamResultListing(alltypes){

    pageFlag = true;
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

function saveApiSettings(){
    let type = 'POST';
    let url = '/saveApiSettings';
    let message = '';
    let form = $('#apiSettings_form');
    let data = new FormData(form[0]);
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveApiSettingsResponse, '', '#saveApiSettings_btn');
}

function saveApiSettingsResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.success == true || response.success == 'true') {

        toastr.success(response.message, '', {
            timeOut: 3000
        });

    } else {

        if (response.status == 402) {

            error = response.message;

        } else {
            error = response.responseJSON.message;
            var is_invalid = response.responseJSON.errors;

            $.each(is_invalid, function (key) {
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

function addParameterValue(id, parameter, parameterId){
    $("#param_id").val(id);
    $("#parameter").val(parameter);
    $("#parameter_id").val(parameterId);
    $("#parameterModal").modal('show');
}

$(document).on('click', '.closeModal', function (e) {

    $("#param_id").val('');
    $("#parameter").val('');
    $("#parameter_id").val('');
    $("#parameterModal").modal('hide');
});

function saveParameterValues(){

    let type = 'POST';
    let url = '/saveParameterValues';
    let message = '';
    let form = $('#addparameter_form');
    let data = new FormData(form[0]);
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveParameterValuesResponse, '', '#saveParam_btn');
}

function saveParameterValuesResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.success == true || response.success == 'true') {

        $("#param_id").val('');
        $("#parameter").val('');
        $("#parameter_id").val('');
        $("#parameterModal").modal('hide');
        
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

            $.each(is_invalid, function (key) {
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

function changeParameterValueOnOff(id){

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

function addDeviceKeyValue(id, deviceKey){
    $("#type_id").val(id);
    $("#device_key").val(deviceKey);
    $("#deviceKeyModal").modal('show');
}

$(document).on('click', '.closeModal1', function (e) {
    $("#type_id").val('');
    $("#device_key").val('');
    $("#deviceKeyModal").modal('hide');
});

function saveDeviceKeyValue(){

    let type = 'POST';
    let url = '/saveDeviceKeyValue';
    let message = '';
    let form = $('#addDeviceKey_form');
    let data = new FormData(form[0]);
    // PASSING DATA TO FUNCTION
    $('input').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', saveDeviceKeyValueResponse, '', '#saveDeviceKey_btn');
}

function saveDeviceKeyValueResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.success == true || response.success == 'true') {

        $("#type_id").val('');
        $("#device_key").val('');
        $("#deviceKeyModal").modal('hide');
        
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

            $.each(is_invalid, function (key) {
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

function updateSystemStatus(){

    let type = 'POST';
    let url = '/updateSystemStatus';
    let message = '';
    let form = '';
    let data = new FormData();
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', updateSystemStatusResponse, '', '');
}

function updateSystemStatusResponse(response) {

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

// ------------------------------ UPDATE TYPE JS CODE ---------------------------
function editType(typeId, title){
    $("#edit_type_id").val(typeId);
    $("#type_title").val(title);

    $("#editTypeModal").modal('show');
}

$(document).on('click', '.closeModal2', function (e) {
    $("#edit_type_id").val('');
    $("#type_title").val('');
    $("#editTypeModal").modal('hide');
});

function updateType(){

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

            $.each(is_invalid, function (key) {
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
function editSubType(subTypeId, title){
    $("#edit_subtype_id").val(subTypeId);
    $("#subtype_title").val(title);

    $("#editSubTypeModal").modal('show');
}

$(document).on('click', '.closeModal3', function (e) {
    $("#edit_subtype_id").val('');
    $("#subtype_title").val('');
    $("#editSubTypeModal").modal('hide');
});

function updateSubType(){

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

            $.each(is_invalid, function (key) {
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
function editParameter(paramId, title1, title2){
    $("#edit_parameter_id").val(paramId);
    $("#pre_title").val(title1);
    $("#post_title").val(title2);

    $("#editParameterModal").modal('show');
}

$(document).on('click', '.closeModal4', function (e) {
    $("#edit_parameter_id").val('');
    $("#pre_title").val('');
    $("#post_title").val('');
    $("#editParameterModal").modal('hide');
});

function updateParameter(){

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

            $.each(is_invalid, function (key) {
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

$(document).ready(function () {

    getDashboardPageData();

    if(refreshTimeInterval > 1000){
        setInterval(() => {
            refreshAllTypesSequentially();
        }, refreshTimeInterval);
    }
    

    $('#image').on('change', function () {
        const file = this.files[0]; // Get the selected file
        const preview = $('#previewImage'); // Image preview element
        
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.html(`<img class="w-100 h-100" src="${e.target.result}" alt="image" style="height:150px;">` );
            };

            reader.readAsDataURL(file); // Read the file as a data URL
        } else {
            preview.html(`<p>No Image Uploaded</p>` );
        }
    });
});

</script>
@endpush