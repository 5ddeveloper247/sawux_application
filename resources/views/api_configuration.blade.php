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
                    <div class="txt py-4">
                        <h3>API DETAILS</h3>
                    </div>
                    <form id="apiSettings_form">
                        @csrf
                        <div class="row">
                            <div class="form-floating col-md-6 col-12 mb-3">
                                <input type="url" class="form-control" id="api_url" name="api_url" placeholder="API URL"
                                    value="{{ @$api_settings->api_url }}" maxlenght="200" required>
                                <label class="mx-2" for="api_url">API URL</label>
                            </div>
                            <div class="form-floating col-md-6 col-12 mb-3">
                                <input type="url" class="form-control" id="system_api_url" name="system_api_url"
                                    placeholder="System API URL" value="{{ @$api_settings->system_api_url }}"
                                    maxlenght="200" required>
                                <label class="mx-2" for="system_api_url">System API URL</label>
                            </div>
                            <div class="form-floating col-md-6 col-12 mb-3">
                                <input type="number" class="form-control" id="api_refresh_time" name="api_refresh_time"
                                    placeholder="API Refresh Time" value="{{ @$api_settings->api_refresh_time }}"
                                    maxlenght="10" required>
                                <label class="mx-2" for="api_refresh_time">API Refresh Time (Seconds)</label>
                            </div>

                            <div class="col-md-6 col-12"></div>

                            <div class="form-floating col-md-6 col-12 mb-3">
                                <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                    single placeholder="" value="">
                                <label class="mx-2" for="">Circuit Image</label>
                            </div>
                            <div class="form-floating col-md-6 col-12 mb-3" id="previewImage">
                                @if (@$api_settings->image != null)
                                    <img class="w-100 h-100" src="{{ @$api_settings->image }}" alt="image">
                                @else
                                    <p>No Image Uploaded</p>
                                @endif

                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <button type="button" class="btn theme-btn-outline my-4 d-flex align-items-center px-md-5 mx-1"
                                id="saveApiSettings_btn" onclick="saveApiSettings();">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
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
        });

        function saveApiSettings() {
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
