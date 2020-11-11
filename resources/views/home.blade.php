@extends('layouts.app')
@if(count($sliders) > 0)
@section('style')
<link rel="stylesheet" href="/css/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/css/nivo-slider.css" type="text/css" media="screen" />
@endsection
@endif

@section('content')
@if(count($sliders) > 0)
<header>
    <div class="header">
        <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
                @foreach($sliders as $item)
                @php
                    $_src = getUrlStorage('banners/'.$item->photo);
                @endphp
                <img src="{!! $_src !!}" data-thumb="{!! $_src !!}" alt="" title="{!! $item->description !!}" />
                @endforeach
            </div>
        </div>
    </div>
    
</header>
@endif

<div class="py-4 py-xs-4">
    <div class="container">
        
        <div id="products" class="row">
        @php
        $_limit_post_title = getLimitPostTitle();
        @endphp 
        @foreach($products as $key => $_entity)
            @php
                $data = $_entity;
            @endphp
            @include ('products.item',['data'=>$data,'limit_post_title'=>$_limit_post_title])
        @endforeach
        </div>
        <div class="infinite-loading invisible"></div>
        <div class="text-center">
            <a id="product-load-more" class="btn btn-primary">{{ __('Load More') }}</a>
        </div>
    </div>
</div>
@endsection

@section('script')
@if(count($sliders) > 0)
<script src="/js/jquery.nivo.slider.js"></script>
@endif
<script>
    var _query_string = '<?php echo getQueryString(['p']); ?>';
    var _slider = parseInt('<?php echo count($sliders); ?>');
    $(document).ready(function(){
        if(_slider > 0){
            $('#slider').nivoSlider();
        }
    })
    
    var post_last_scroll = 0;
    var post_current_page = parseInt('<?php echo $page; ?>');
    var post_total_page = parseInt('<?php echo $products->total(); ?>');
    var _last_page = parseInt('<?php echo $products->lastPage(); ?>');
    var _current_page = parseInt('<?php echo $products->currentPage(); ?>');
    var post_next_page = post_current_page + 1;

    if(_last_page == _current_page){
        removeLoadMoreBtn();
    }
    
    $('#products').after('<div class="infinite-scroll-trigger"></div>');

    var _base_url = '<?php echo route("home",getLang()); ?>'; 
    var _ajaxurl = _base_url;
    _ajaxurl += '?';
    _ajaxurl += _query_string;
    if(_query_string){
        _ajaxurl += '&';
    }
    _ajaxurl += 'page=';

    function loadNextPage(){
        if(!$('body').hasClass('infinite-loading-pending')){
            infiniteLoading();
            var _url = _ajaxurl + post_next_page;
            axios.get(_url)
                .then(response => {
                    removeInfiniteLoading();
                    var _data = response.data;
                    var _html = _data.html;
                    var _page = parseInt(_data.page);
                    var _total = parseInt(_data.total);
                    if(_page >= _total){
                        post_next_page = (_total + 1)
                        addInitToBody();
                        removeLoadMoreBtn();
                    }else{
                        post_next_page = (_page + 1);
                        removeInitToBody()
                    }
                    if(_html){
                        var _el = $('#products').append(_html);
                        // var _history_url = _base_url;
                        // _history_url += '?' + _query_string;
                        // if(_query_string){
                        //     _history_url += '&';
                        // }
                        //_history_url += 'p=' + _page;
                        //window.history.pushState("", "", _history_url);
                    }else{
                        removeLoadMoreBtn();
                    }
                }).catch(error => {
                    removeInfiniteLoading();
                });
        }
    }

    function removeLoadMoreBtn(){
        $('#product-load-more').closest('div.text-center').remove();
    }

    function updateUrlParameter(param, value) {
        const regExp = new RegExp(param + "(.+?)(&|$)", "g");
        const newUrl = window.location.href.replace(regExp, param + "=" + value + "$2");
        window.history.pushState("", "", newUrl);
    }

    function updateQueryString(key, value, url) {
        if (!url) url = window.location.href;
        var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
            hash;

        if (re.test(url)) {
            if (typeof value !== 'undefined' && value !== null)
                return url.replace(re, '$1' + key + "=" + value + '$2$3');
            else {
                hash = url.split('#');
                url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
                if (typeof hash[1] !== 'undefined' && hash[1] !== null) 
                    url += '#' + hash[1];
                return url;
            }
        }else {
            if (typeof value !== 'undefined' && value !== null) {
                var separator = url.indexOf('?') !== -1 ? '&' : '?';
                hash = url.split('#');
                url = hash[0] + separator + key + '=' + value;
                if (typeof hash[1] !== 'undefined' && hash[1] !== null) 
                    url += '#' + hash[1];
                return url;
            }
            else
                return url;
        }
    } 

    function removeInfiniteLoading(){
        removeInitToBody()
        $('.infinite-loading').removeClass('visible').addClass('invisible');
        $('#product-load-more').removeClass('invisible').addClass('visible');
    }

    function infiniteLoading(){
        addInitToBody();
        $('.infinite-loading').removeClass('invisible').addClass('visible');
        $('#product-load-more').removeClass('visible').addClass('invisible');
    }

    function addInitToBody(){
        $('body').addClass('infinite-loading-pending');
    }
    function removeInitToBody(){
        $('body').removeClass('infinite-loading-pending');
    } 

    $(document).on('click','#product-load-more',function(){
        loadNextPage();
    });
    
</script>

@endsection
