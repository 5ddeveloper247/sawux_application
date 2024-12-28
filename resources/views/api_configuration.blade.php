{{--
    dd($api_settings);
--}}
@extends('layouts.admin.admin_master')

@push('css')
    
@endpush

@section('content')
    <div>
        <div class="px-3 py-4 my-3 sub-bg p-3 rounded-4">
            <div class="d-flex justify-content-between">
                <div class="txt py-4">
                    <h4 class="m-text fw-bold">API DETAILS</h4>
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

            <form id="apiSettings_form">
                @csrf
                <div class="row">
                    <div class="form-floating col-md-6 col-12 mb-3">
                        <input type="url" class="form-control" id="api_url" name="api_url" placeholder=""
                            value="" maxlenght="200" required>
                        <label class="mx-2" for="api_url">API URL</label>
                    </div>

                    <div class="form-floating col-md-6 col-12 mb-3">
                        <input type="url" class="form-control" id="system_api_url" name="system_api_url"
                            placeholder="" value="" maxlenght="200" required>
                        <label class="mx-2" for="system_api_url">System API URL</label>
                    </div>

                    <div class="form-floating col-md-6 col-12 mb-3">
                        <input type="number" class="form-control" id="api_refresh_time" name="api_refresh_time"
                            placeholder="" value="" maxlenght="10" required>
                        <label class="mx-2" for="api_refresh_time">API Refresh Time (Seconds)</label>
                    </div>

                    <div class="form-floating col-md-6 col-12 mb-3">
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" single
                            placeholder="" value="">
                        <label class="ms-2" for="">Circuit Image</label>
                    </div>
                    <div class="form-floating col-md-6 col-12 mb-3" id="previewImage">

                        <img class="w-100 h-100" src="" id="imageSrc" alt="image">


                    </div>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <button type="button" class="btn theme-btn-outline my-4 d-flex align-items-center px-md-5 mx-1"
                        id="saveApiSettings_btn" onclick="saveApiSettings();">SAVE</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#image').on('change', function() {
                const file = this.files[0]; // Get the selected file
                const preview = $('#previewImage'); // Image preview element

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.html(
                            `<img class="w-100 h-100" src="${e.target.result}" alt="image" style="height:150px;">`
                        );
                    };

                    reader.readAsDataURL(file); // Read the file as a data URL
                } else {
                    preview.html(`<p>No Image Uploaded</p>`);
                }
            });
            apiconfiguration();
            $("#location_id").change(function() {

                apiconfiguration();
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
                        $("#api_url").val(response.data.api_url);
                        $("#system_api_url").val(response.data.system_api_url);
                        $("#api_refresh_time").val(response.data.api_refresh_time);
                        $("#imageSrc").attr('src', response.data.image);
                    } else {
                        $("#api_url").val('');
                        $("#system_api_url").val('');
                        $("#api_refresh_time").val('');
                        $("#imageSrc").attr('src', '');
                        $("#imageSrc").hide();
                    }
                }
            }
        });

        function saveApiSettings() {
            let type = 'POST';
            let url = '/saveApiSettings';
            let message = '';
            let location_id = $("#location_id").val();
            let form = $('#apiSettings_form');
            let data = new FormData(form[0]);
            data.append('location_id', location_id);
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
    </script>
@endpush
