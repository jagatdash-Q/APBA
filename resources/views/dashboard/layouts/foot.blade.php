<script type="text/javascript">
    var public_lang = "en";
    var public_folder_path = "{{ asset('') }}";
    var first_day_of_week = "{{ env('FIRST_DAY_OF_WEEK',0) }}";

    $(document).ready(function(){
  $("#myform").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
})

$("#preview_btn").click(function(){ 
$("#myform").attr("target", "_blank");
setTimeout(function () {
  $("#pageloader").fadeOut();
  $("#myform").removeAttr("target", "_blank");
                 }, 1500);
  });
</script>
@stack('before-scripts')
<!-- jQuery -->
<!-- Bootstrap -->
{{-- <script src="{{ asset('assets/dashboard/js/tether/dist/js/tether.min.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/bootstrap/dist/js/bootstrap.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/moment/moment.js') }}" defer></script>
<!-- core -->
<script src="{{ asset('assets/dashboard/js/underscore/underscore-min.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/jQuery-Storage-API/jquery.storageapi.min.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/pace/pace.min.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/scripts/config.lazyload.js') }}" defer></script>

<script src="{{ asset('assets/dashboard/js/scripts/palette.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/scripts/ui-load.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/scripts/ui-jp.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/scripts/ui-include.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/scripts/ui-device.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/scripts/ui-form.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/scripts/ui-nav.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/scripts/ui-screenfull.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/scripts/ui-scroll-to.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/js/scripts/ui-toggle-class.js') }}" defer></script> --}}

{{-- Media manager files include --}}
<script src="{{ asset('assets/dashboard/media_manager/vendor/multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{ asset('assets/dashboard/media_manager/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{ asset('assets/dashboard/media_manager/js/app.js').'?v=' . filemtime(base_path() . '/public/assets/dashboard/media_manager/js/app.js')}}"></script>
{{-- <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script> --}}
{{-- End of media manager files include --}}
<script src="{{ asset('assets/dashboard/js/scripts/app.js') }}" defer></script>
<script src="{{ asset('assets/dashboard/ckeditor/ckeditor.js') }}"></script>
{{-- <script src="{{ asset('assets/dashboard/js/script.js') }}"></script> --}}
@stack('after-scripts')
