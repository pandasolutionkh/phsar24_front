@php
    $_id = $data->id;
    $_time = getNumberOfDays($data->updated_at,date('Y-m-d H:i:s'));
    $_countLiked = count($data->post_likes);
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
                                    <strong class="product-title">{{ $data->name }}</strong>
                                </div>
                                @guest
                                @else
                                <div class="d-table-cell text-right w-15px">
                                    <a href=""><i class="fa fa-heart-o"></i></a>
                                </div>
                                @endguest
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

            @if(floatval($data->price) > 0 || intval($data->promotion) > 0)
            <div class="product-like">
                <div class="d-table w-100">
                    <div class="d-table-row">
                        <div class="d-table-cell">
                            @if(floatval($data->price) > 0)
                            <a class="btn btn-secondary btn-sm">
                                ${{ $data->price }}
                            </a>
                            @endif
                        </div>
                        <div class="d-table-cell text-right">
                            @if(intval($data->promotion) > 0)
                            <a class="btn btn-primary btn-sm">
                                {{ $data->promotion }}% OFF
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>