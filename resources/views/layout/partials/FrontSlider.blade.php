<div class="c-content-box">
    <div id="slider" class="owl-theme section section-cate slideshow_full_width ">
        <div id="slide_banner" class="owl-carousel owl-loaded owl-drag">

            <div class="owl-stage-outer">
                <div class="owl-stage" style="width: 5775px; transform: translate3d(-2310px, 0px, 0px); transition: all 0.25s ease 0s;">
                    @php($sliders = \App\Helpers\Widgets::getSlider())
                    @foreach($sliders as $slider)
                        <div class="owl-item cloned" style="width: 1155px;">
                            <div class="item">
                                <a href="/" alt="tc">
                                    <img src="{{$slider['thumb']}}" alt="tc">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="owl-nav disabled">
                <button type="button" role="presentation" class="owl-prev"><i class="fa fa-angle-left"></i></button>
                <button type="button" role="presentation" class="owl-next"><i class="fa fa-angle-right right_button"
                                                                              aria-hidden="true"></i></button>
            </div>
            <div class="owl-dots disabled"></div>
        </div>
    </div>
</div>