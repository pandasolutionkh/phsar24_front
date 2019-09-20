
@php
$_time = getNumberOfDays($data->updated_at,date('Y-m-d H:i:s'));
$_incr = 0;
@endphp
<div class="row">
    <div class="col-lg-9">
        <div id="viewProduct" class="carousel mb-5" data-ride="carousel">
            
            <div class="carousel-inner">
            @foreach($data->galleries as $item)
                @php
                    $_act = '';
                    $_name = $item->name;
                    $_src = getUrlStorage('products/'.$_name);
                    if($_incr == 0){
                        $_act = 'active';
                    }
                @endphp
              
                <div class="carousel-item {{ $_act }}">
                  <img src="{{ $_src }}" alt="" />
                </div>
                @php
                    $_incr++;
                @endphp
            @endforeach
            </div>

            <a class="carousel-control-prev" href="#viewProduct" role="button" data-slide="prev">
                <i class="fa fa-angle-left fa-3x"></i>
            </a>
            <a class="carousel-control-next" href="#viewProduct" role="button" data-slide="next">
                <i class="fa fa-angle-right fa-3x"></i>
            </a>

            <ol class="carousel-indicators">
                @for($ind=0; $ind < count($data->galleries); $ind++)
                @php
                    $_act = '';
                    if($ind == 0){
                        $_act = 'active';
                    }
                @endphp
                <li data-target="#viewPost" data-slide-to="{{ $ind }}" class="{{ $_act }}">&nbsp;</li>
                @endfor
            </ol>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="product">
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
                <p>{!! nl2br($data->description) !!}</p>
            </div>
        </div>
    </div>
</div>


