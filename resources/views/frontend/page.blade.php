@extends('layout.FrontMaster')

@section('content')

    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: Title 1 component -->
                    <div class="c-content-title-1">
                        <h3 class="c-font-uppercase c-font-bold">{{ $category['title'] }}</h3>
                        <div class="c-line-left c-theme-bg"></div>
                    </div>
                    <!-- End-->
                    <div class="content_post">
                        {!! $content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection