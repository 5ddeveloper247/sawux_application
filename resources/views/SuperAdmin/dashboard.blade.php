{{--
    dd($api_settings);
--}}
@extends('layouts.super_admin.master')

@push('css')

@endpush

@section('content')

<div>
    
    <div class="p-md-4 p-3">
        <div class="d-flex align-items-center mb-4">
            <a href="{{route('superadmin.dashboard')}}" class="back-to-add-form mb-2 text-dark" style="cursor:pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M48 256c0 114.87 93.13 208 208 208s208-93.13 208-208S370.87 48 256 48S48 141.13 48 256m212.65-91.36a16 16 0 0 1 .09 22.63L208.42 240H342a16 16 0 0 1 0 32H208.42l52.32 52.73A16 16 0 1 1 238 347.27l-79.39-80a16 16 0 0 1 0-22.54l79.39-80a16 16 0 0 1 22.65-.09" />
                </svg>
            </a>
            <nav class="ms-3 mt-2" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <!-- <li class="breadcrumb-item active" aria-current="page">Audio Questions</li> -->
                </ol>
            </nav>
        </div>
        <div id="products">
           
        </div>
    </div>

</div>

@endsection
