@php
    $_id = $data->id;
    $_time = getNumberOfDays($data->updated_at,date('Y-m-d H:i:s'));
    $_countLiked = 0;//count($data->post_likes);
    $_url_detail = route('products.detail',['id'=>$_id,'locale'=>getLang()]);
    $_url_fav = route('favorites.dofav',['id'=>$_id,'locale'=>getLang()]);
@endphp
<div class="col-md-3 mb-2">
    <div class="card" data-id="p{{ $_id }}">
        <div class="card-body product">
            <div class="clearfix">
                <div class="d-inline-block w-100">
                    <div>
                        <div class="d-table w-100">
                            <div class="d-table-row">
                                <div class="d-table-cell">
                                    <a href="{{ $_url_detail }}">
                                        <strong class="product-title">{{ $data->name }}</strong>
                                    </a>
                                </div>
                                <div class="d-table-cell text-right w-15px">
                                @guest
                                
                                    <a href="{{ route('favorites.index',getLang()) }}">
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                
                                @else
                                    <a data-url="{{ $_url_fav }}" href="" class="btn-product-favorite">
                                        @php
                                            if($data->favorited()){
                                                $_fh = 'fa-heart';
                                            }else{
                                                $_fh = 'fa-heart-o';
                                            }
                                        @endphp
                                        <i class="fa {{ $_fh }}"></i>
                                    </a>
                                @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-time">
                        <i class="fa fa-clock-o"></i> {{ $_time }}
                    </div>
                </div>
            </div>
            <div class="product-content"> 
                {!! showContentMore($data->description,10,1) !!}
            </div>
            
            @php
                $_galleries = $data->galleries;
                $_count = count($data->galleries);
            @endphp

            @if( $_count > 0)
            
            @php
                $_remain = 0;
                if($_count > 5){
                    $_remain = $_count - 5;
                    $_count = 5;
                }    
                $_incr = 0;
            @endphp

            <div class="product-image imgs-grid imgs-grid-{{$_count}}" data-url="{{ $_url_detail }}" data-toggle="modal" data-target="#modalPopup">
                @foreach($_galleries as $item)
                    @php
                        if($item->is_lock) continue; //when administrator block

                        if($_incr == $_count) break;

                        $_name = $item->name;
                        $_src = getUrlStorage('products/'.$_name);
                    @endphp

                    <div class="imgs-grid-image">
                        <div class="image-wrap">
                            <img src="{{ $_src }}" alt="" />
                            
                            @if($_incr == ($_count-1) && $_remain > 0)
                            <div class="view-all">
                                <span class="view-all-cover"></span>
                                <span class="view-all-text">+{{ $_remain }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @php
                        $_incr++;
                    @endphp
                @endforeach
            </div>
            @endif

            
            <div class="product-like">
                <div class="d-table w-100">
                    <div class="d-table-row">
                        <div class="d-table-cell">
                            @php
                                $_href = route('products.detail',['id'=>$_id,'locale'=>getLang()]);
                                $_title = $data->name;
                                $_fb_share = "https://www.facebook.com/sharer/sharer.php?u=$_href&t=$_title";
                            @endphp
                            <a href="{{ $_fb_share }}" data-network="facebook" class="btn btn-share-fb btn-sm share" data-layout="button_count">
                                <i class="fa fa-facebook"></i> {{ __('Share') }}
                            </a>
                        </div>
                        <div class="d-table-cell text-right">
                            @if(floatval($data->price) > 0 || intval($data->promotion) > 0)
                                @if(intval($data->promotion) > 0)
                                <a class="btn btn-secondary btn-sm">
                                    ${{ $data->promotion }}
                                </a>
                                
                                <a class="text-promotion">
                                    <del>${{ $data->price }}</del>
                                </a>
                                @elseif(floatval($data->price) > 0)
                                <a class="btn btn-secondary btn-sm">
                                    ${{ $data->price }}
                                </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>