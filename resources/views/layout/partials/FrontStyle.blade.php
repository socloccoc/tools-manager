<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&amp;subset=all'
      rel='stylesheet' type='text/css'>
<link href="{{ asset('plugins/socicon/socicon.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('plugins/bootstrap-social/bootstrap-social.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('plugins/animate/animate.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
      type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN: BASE PLUGINS  -->
<link href="{{ asset('global/magnific/magnific.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('plugins/cubeportfolio/css/cubeportfolio.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('plugins/owl-carousel/assets/owl.carousel.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet" type="text/css"/>
<!-- END: BASE PLUGINS -->

<!-- BEGIN: PAGE STYLES -->
<link href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
      rel="stylesheet" type="text/css"/>
<link href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
      rel="stylesheet" type="text/css"/>
<link href="{{ asset('plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
      rel="stylesheet" type="text/css"/>
<link href="{{ asset('plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
      rel="stylesheet" type="text/css"/>
<!-- END: PAGE STYLES -->

<!-- BEGIN THEME STYLES -->
<link href="{{ asset('demos/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('demos/css/components.css') }}" id="style_components" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('demos/css/themes/default.css') }}" rel="stylesheet" id="style_theme"
      type="text/css"/>
<link href="{{ asset('demos/css/custom.css') }}" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" href="{{ asset('frontend/plugins/owl-carousel/owl.carousel.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugins/owl-carousel/owl.theme.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/plugins/owl-carousel/owl.transitions.css') }}">

<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<style>
    .ui-autocomplete {
        max-height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .input-group-addon {
        background-color: #FAFAFA;
    }

    .input-group .input-group-btn > .btn,
    .input-group .input-group-addon {
        background-color: #FAFAFA;
    }

    .modal {
        text-align: center;
    }

    @media screen and (min-width: 768px) {
        .modal:before {
            display: inline-block;
            vertical-align: middle;
            content: " ";
            height: 100%;
        }
    }

    @media (min-width: 992px) and (max-width: 1200px) {
        .c-layout-header-fixed.c-layout-header-topbar .c-layout-page {
            margin-top: 245px;
        }
    }

    @media screen and (max-width: 767px) {
        .modal-dialog:before {
            margin-top: 75px;
            display: inline-block;
            vertical-align: middle;
            content: " ";
            height: 100%;
        }

        .modal-dialog {
            width: 100%;

        }

        .modal-content {
            margin-right: 20px;
        }
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;


    }

    .mfp-wrap {
        z-index: 20000 !important;
    }

    .c-content-overlay .c-overlay-wrapper {
        z-index: 6;
    }

    .z7 {
        z-index: 7 !important;
    }

    .error-message {
        color: #fff;
        background: #ff0000;
        padding: 5px;
        position: absolute;
        margin-top: 2px;
        font-size: 12px;
        z-index: 1000;
    }
    .error {
        border: 1px solid #ff0000;
    }
</style>
<script src="{{ asset('frontend/plugins/jquery/jquery-2.1.0.min.js') }}"></script>