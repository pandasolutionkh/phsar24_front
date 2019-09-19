@php
    $_id = $data->id;
    $_time = getNumberOfDays($data->updated_at,date('Y-m-d H:i:s'));
    $_countLiked = count($data->post_likes);
@endphp
<div class="cols">
    <div class="card" data-id="p{{ $_id }}">
        <div class="card-body product">
            <div class="clearfix">
                <div class="d-inline-block">
                    <div>
                        <strong>{{ $data->name }}</strong>
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

            <div class="product-image imgs-grid imgs-grid-1" data-id="{{ $_id }}" data-toggle="modal" data-target="#modalPopup">
                @foreach($_galleries as $item)
                    @php
                        if($_incr == $_count) break;
                        $_name = $item->name;
                        $_src = getUrlStorage('products/'.$_name);
                    @endphp

                    <div class="imgs-grid-image">
                        <div class="image-wrap">
                            <img src="{{ $_src }}" alt="" />
                        </div>
                    </div>
                    @php
                        break;
                        $_incr++;
                    @endphp
                @endforeach
            </div>
            @endif

            @if($data->price > 0 || $data->promotion > 0)
            <div class="product-like">
                <div class="d-table w-100">
                    <div class="d-table-row">
                        <div class="d-table-cell">
                            <a class="btn btn-secondary btn-sm">
                                @if($data->price > 0)
                                ${{ $data->price }}
                                @endif
                            </a>
                        </div>
                        <div class="d-table-cell text-right">
                            <a class="btn btn-primary btn-sm">
                                @if($data->promotion > 0)
                                {{ $data->promotion }}%
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>