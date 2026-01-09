<meta charset="utf-8" />
<title>@yield('title')</title>
{{-- <meta name="description" content="{{ Helper::GeneralSiteSettings('site_desc_'.@Helper::currentLanguage()->code) }}"/> --}}
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
{{-- <link rel="apple-touch-icon" href="{{ asset('assets/dashboard/images/logo.png') }}"> --}}
{{-- <meta name="apple-mobile-web-app-title" content="Smartend"> --}}
<base href="{{ route('adminHome') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="mobile-web-app-capable" content="yes">
{{-- <link rel="shortcut icon" sizes="196x196" href="{{ asset('assets/dashboard/images/logo.png') }}"> --}}
@stack('before-styles')
<link rel="stylesheet" href="{{ asset('assets/dashboard/css/animate.css/animate.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/dashboard/css/animate.css/animate.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/dashboard/fonts/glyphicons/glyphicons.css') }}" type="text/css" />

<link rel="stylesheet" href="{{ asset('assets/dashboard/fonts/material-design-icons/material-design-icons.css') }}"
    type="text/css" />
{{-- <link rel="stylesheet" href="{{ asset('assets/dashboard/fonts/font-awesome/css/font-awesome.min.css') }}"
      type="text/css"/> 

<link rel="stylesheet" href="{{ asset('assets/dashboard/css/bootstrap/dist/css/bootstrap.min.css') }}"
      type="text/css"/> 
<link rel="stylesheet" href="{{ asset('assets/dashboard/css/app.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/dashboard/css/font.css') }}" type="text/css"/>
 <link rel="stylesheet" href="{{ asset('assets/dashboard/css/topic.css') }}" type="text/css"/> --}}


<script src="{{ asset('assets/dashboard/js/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/custom/jquery-ui.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/dashboard/css/custom/jquery-ui.css') }}">
{{-- Media manager files include --}}


<script src="{{ asset('assets/dashboard/media_manager/js/ajaxForm.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/dashboard/media_manager/css/ajaxForm.css') }}">

{{-- End of Media manager files include --}}
<link href='{{ asset('assets/dashboard/select2/css/select2.min.css') }}' rel='stylesheet' type='text/css'>
<script src='{{ asset('assets/dashboard/select2/js/select2.min.js') }}' type='text/javascript'></script>
{{-- Sweet alert include --}}
<script src="{{ asset('assets/dashboard/sweetalert/sweetalert-dev.js') }}"></script>
<script src="{{ asset('assets/dashboard/sweetalert/sweetalert.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/dashboard/sweetalert/sweetalert.css') }}">
{{-- End of Sweet alert include --}}
{{-- Include common css --}}
<link type="text/css" rel="stylesheet"
    href="{{ asset('assets/dashboard/css/custom/common.css') . '?v=' . filemtime(base_path() . '/public/assets/dashboard/css/custom/common.css') }}">


<link rel="stylesheet" href="{{ asset('assets/dashboard/grapesjs/css/grapes.min.css') }}">
<script src="{{ asset('assets/dashboard/grapesjs/grapes.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/grapesjs/js/grapesjs-blocks-basic/dist/index.js') }}"></script>
<script src="{{ asset('assets/dashboard/grapesjs/js/grapesjs-custom-code/dist/index.js') }}"></script>
<script src="{{ asset('assets/dashboard/grapesjs/js/grapesjs-plugin-forms/dist/index.js') }}"></script>
<script src="{{ asset('assets/dashboard/grapesjs/js/grapesjs-preset-webpage/dist/index.js') }}"></script>
<script src="{{ asset('assets/dashboard/grapesjs/js/grapesjs-tabs/dist/grapesjs-tabs.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/grapesjs/custom-table.js') }}"></script>
<script src="{{ asset('assets/dashboard/grapesjs/common-grape.js') }}"></script>

<link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Styles -->
<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/dashboard/css/style.css') }}" rel="stylesheet">

<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     var loader = document.getElementById("loader");
    //     loader.style.display = "block"; // Show the loader initially

    //     window.addEventListener("load", function() {
    //         loader.style.display = "none"; // Hide the loader once the page has fully loaded
    //     });
    // });
</script>
{{-- <script src="https://unpkg.com/grapesjs-preset-webpage@1.0.2/dist/index.js"></script>
<script src="https://unpkg.com/grapesjs-plugin-forms"></script>
<script src="https://unpkg.com/grapesjs-custom-code"></script>
<script src="https://unpkg.com/grapesjs-blocks-basic"></script>
<script src="https://unpkg.com/grapesjs-tabs"></script> --}}
{{-- <script src="{{ asset('assets/dashboard/js/jquery/dist/jquery.js') }}"></script> --}}

@stack('after-styles')
