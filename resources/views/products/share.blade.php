@extends('layouts.app')

@section('content')

<div class="py-4">
    <div class="container">
    	<div class="row">
    		<div class="col-sm-8">
    			<div class="row">
    				<div class="col-sm-5">
    					@php
						$_time = getNumberOfDays($data->updated_at,date('Y-m-d H:i:s'));
						$_incr = 0;
						@endphp
						<div class="card">
						    @foreach($data->galleries as $item)
				                @php
				                if($item->is_cover){
				                    $_name = $item->name;
				                    $_src = getUrlStorage('products/'.$_name);
				                @endphp
					                <img class="card-img-top" src="{{ $_src }}" alt="" />
				                @php
				                }
				                @endphp
				            @endforeach
						</div>
    				</div>
					<div class="col-sm-7">
						<div class="product-detail clearfix">
			                <div class="d-inline-block">
			                    <div class="product-title">
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
    		<div class="col-sm-4">
    			<div class="card">
    				<div class="card-header p-2">
						Related Product
					</div>
    				<div class="card-body p-2">
						Related Product
					</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
@endsection

