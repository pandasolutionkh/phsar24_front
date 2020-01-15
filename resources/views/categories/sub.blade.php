@extends('layouts.user')

@section('user_menu')
    @include('categories.menu')
@endsection

@section('content')
    <h1 class="title">{{ $category->name }}</h1>
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
        <a id="product-load-more" class="btn btn-primary btn-block"><i class="fa fa-refresh"></i> Load More</a>
    </div>
@endsection

@section('script')
<script>
    var _query_string = '<?php echo getQueryString(['p']); ?>';
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

    var _base_url = '<?php echo route("categories.sub",['category_slug'=>$category_slug,'sub_category_slug'=>$sub_category_slug]); ?>'; 
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