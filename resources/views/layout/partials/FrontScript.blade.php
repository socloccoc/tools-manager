<script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/plugins/owl-carousel/slider.js') }}"></script>

<script src="{{ asset('frontend/plugins/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ asset('plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery.easing.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/reveal-animate/wow.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/reveal-animate/reveal-animate.js') }}"
        type="text/javascript"></script>
<!-- END: CORE PLUGINS -->
<!-- BEGIN: LAYOUT PLUGINS -->
<script src="{{ asset('global/magnific/magnific.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/cubeportfolio/js/jquery.cubeportfolio.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/fancybox/jquery.fancybox.pack.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/smooth-scroll/jquery.smooth-scroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/js-cookie/js.cookie.js') }}" type="text/javascript"></script>
<!-- END: LAYOUT PLUGINS -->
<!-- BEGIN: THEME SCRIPTS -->
<script src="{{ asset('base/js/components.js') }}" type="text/javascript"></script>
<script src="{{ asset('base/js/app.js') }}" type="text/javascript"></script>

<script src="{{ asset('frontend/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        App.init(); // init core
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    $(".menu-main-mobile a").click(function () {

        if ($(this).closest("li").hasClass("c-open")) {
            $(this).closest("li").removeClass("c-open");
        } else {
            $(this).closest("li").addClass("c-open");
        }
    });

</script>
<!-- END: THEME SCRIPTS -->
<!-- BEGIN: PAGE SCRIPTS -->
<script src="{{ asset('plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('demos/js/scripts/pages/datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/plugins/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js') }}"
        type="text/javascript"></script>

<script src="{{ asset('js/common.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/js/base.js') }}" type="text/javascript"></script>