<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Media Manager</title>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="{{ asset('assets/dashboard/media_manager/gallery-manager/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/dashboard/media_manager/gallery-manager/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/dashboard/media_manager/gallery-manager/css/magnific-popup.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/dashboard/media_manager/gallery-manager/css/media.css')}}">
	{{-- <link rel="stylesheet" href="{{ asset('assets/dashboard/media_manager/gallery-manager/css/mediaelementplayer.min.css')}}"> --}}
	{{-- <link rel="stylesheet" href="{{ asset('assets/dashboard/media_manager/gallery-manager/css/mejs-skins.min.css')}}"> --}}
</head>

<body>
	<input type="hidden" name="base_url" id="base_url" value="{{url('/')}}">
	@include($page)

	<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/jquery.min.js')}}"></script>
	<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/tether.min.js')}}"></script>
	<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/dropzone.min.js')}}"></script>
	<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/js.cookie.js')}}"></script>
	<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/bootbox.min.js')}}"></script>
	<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/masonry.pkgd.min.js')}}"></script>
	{{-- <script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/pwstrength-bootstrap.min.js')}}"></script> --}}
	<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/media.js')}}"></script>
	<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/client.js')}}"></script>
	<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/mediaelement-and-player.min.js')}}"></script>
</body>
</html>