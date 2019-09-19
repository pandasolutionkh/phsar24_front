@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="/css/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/css/nivo-slider.css" type="text/css" media="screen" />
@endsection

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

<div class="py-4">
    <div class="container">
        
        <div id="products" class="make-columns"> 
        @foreach($products as $key => $_entity)
            @php
                $data = $_entity;
            @endphp
            @include ('products.item',$data)
        @endforeach
        </div>
        <div class="infinite-loading invisible"></div>
        <div class="text-center">
            <a id="product-load-more" class="btn btn-primary">Load More</a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/js/jquery.nivo.slider.js"></script>
<script>
    $(document).ready(function(){
        $('#slider').nivoSlider();
    })
    
    var post_last_scroll = 0;
    var post_current_page = parseInt('<?php echo $page; ?>');
    var post_total_page = parseInt('<?php echo $products->total(); ?>');
    var post_next_page = post_current_page + 1;
    
    $('#products').after('<div class="infinite-scroll-trigger"></div>');

    var _ajaxurl = '<?php echo route("home"); ?>';
    _ajaxurl += '?page=';

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
                        addInitToBody()
                    }else{
                        post_next_page = (_page + 1);
                        removeInitToBody()
                    }
                    if(_html){
                        var _el = $('#products').append(_html);
                        window.history.pushState("", "", updateQueryString('p',_page));
                    }
                }).catch(error => {
                    removeInfiniteLoading();
                });
        }
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
    }

    function infiniteLoading(){
        addInitToBody();
        $('.infinite-loading').removeClass('invisible').addClass('visible');
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
