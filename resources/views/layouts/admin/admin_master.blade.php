<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    {{-- <link rel="stylesheet" href="{{asset('assets/css/style-2.css')}}"> --}}

    <!-- Standard favicon -->
    <link rel="icon" href="{{ asset('assets/favicon/favicon.ico') }}" sizes="16x16">

    <!-- High-resolution favicon -->
    <link rel="icon" href="{{ asset('assets/favicon/favicon-32x32.png') }}" sizes="32x32">

    <!-- Apple touch icon -->
    <link rel="apple-touch-icon" href="{{ asset('assets/favicon/apple-touch-icon.png') }}" sizes="180x180">

    <!-- Android and Windows tiles -->
    <link rel="icon" href="{{ asset('assets/favicon/favicon-192x192.png') }}" sizes="192x192">
    <link rel="icon" href="{{ asset('assets/favicon/favicon-144x144.png') }}" sizes="144x144">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/niceselect/custom-styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/tagsinput/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" />
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    {{-- <!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous"
  referrerpolicy="no-referrer" />
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    @stack('css')
</head>

<body>
    <div class="preloader">
        <div class="circle circle5 c51"></div>
    </div>

    {{-- @auth
        @include('layouts.admin.header')
    @endauth --}}

    <div   @auth  @if(auth()->user()->role == '3')  @else class="d-flex"  @endif @endauth>
        @auth
            @if (auth()->user()->role == '2')
                <!-- side bar code here -->
                @include('layouts.admin.sidebar')
            @endif
        @endauth
        @auth
            <div    @auth  @if(auth()->user()->role == '3') style="color:white"  @else class="content"  @endif @endauth>
                <!-- main content -->
                @auth
                    @include('layouts.admin.header')
                @endauth

                @yield('content')

                @include('layouts.admin.footer')
            </div>
        @endauth

        @include('layouts.admin.footer')

        @guest
            @yield('content')
        @endguest
    </div>


    <!-- Footer code here -->
    {{-- Toastr::message() --}}
</body>
@stack('script')

</html>
