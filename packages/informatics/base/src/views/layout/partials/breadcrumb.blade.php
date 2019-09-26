<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        @foreach($breadcrumbs as $breadcrumb)
            <a href="{{@$breadcrumb['url']?$breadcrumb['url']:'#'}}" class="{{@$loop->last?'breadcrumb-item active':'breadcrumb-item'}}">
                {!! @$breadcrumb['icon'] !!} {{$breadcrumb['label']}}
            </a>
        @endforeach
    </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">{!! @$title !!}</h4>
    <p class="mg-b-0">{!! @$sub_title !!}</p>
</div>