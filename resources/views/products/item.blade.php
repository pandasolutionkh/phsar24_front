@php
    $_id = $data->id;
    $_time = getNumberOfDays($data->updated_at,date('Y-m-d H:i:s'));
    $_countLiked = 0;//count($data->post_likes);
@endphp
<div class="cols">
    <div class="card" data-id="p{{ $_id }}">
        <div class="card-body product">
            <div class="clearfix">
                <div class="d-inline-block w-100">
                    <div>
                        <div class="d-table w-100">
                            <div class="d-table-row">
                                <div class="d-table-cell">
                                    <a href="{{ route('products.detail',$_id) }}">
                                        <strong class="product-title">{{ $data->name }}</strong>
                                    </a>
                                </div>
                                <div class="d-table-cell text-right w-15px">
                                @guest
                                
                                    <a href="{{ route('favorites.index') }}">
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                
                                @else
                                    <a data-id="{{ $_id }}" href="" class="btn-product-favorite">
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
                {!! showContentMore($data->description) !!}
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

            <div class="product-image imgs-grid imgs-grid-{{$_count}}" data-id="{{ $_id }}" data-toggle="modal" data-target="#modalPopup">
                @foreach($_galleries as $item)
                    @php
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
                                $_href = route('products.detail',$_id);
                                $_title = $data->name;
                                $_fb_share = "https://www.facebook.com/sharer/sharer.php?u=$_href&t=$_title";
                            @endphp
                            <a href="{{ $_fb_share }}" data-network="facebook" class="btn btn-share-fb btn-sm share" data-layout="button_count">
                                <i class="fa fa-facebook"></i> Share
                            </a>
                        </div>
                        <div class="d-table-cell text-right">
                            @if(floatval($data->price) > 0 || intval($data->promotion) > 0)
                                @if(floatval($data->price) > 0)
                                <a class="btn btn-secondary btn-sm">
                                    ${{ $data->price }}
                                </a>
                                @endif

                                @if(intval($data->promotion) > 0)
                                <a class="btn btn-primary btn-sm">
                                    {{ $data->promotion }}% OFF
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