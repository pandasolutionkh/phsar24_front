@extends('layouts.app')

@section('meta_title')
    <title>Product | {{ $data->name }}</title>
@endsection

@section('meta')
	@php
		$_meta_image = '';
		$_share_link = route('products.detail',['locale'=>getLang(),'id'=>$data->id]);
	@endphp

	@foreach($data->galleries as $item)
        @php
        if($item->is_cover){
            $_name = $item->name;
            $_meta_image = getUrlStorage('products/'.$_name);
        }
        @endphp
    @endforeach
    <meta property="fb:app_id"        content="{{ ENV('FACEBOOK_APP_ID') }}"/>
    <meta property="og:site_name"     content="{{ ENV('APP_NAME') }}">
    <meta property="og:url"           content="{{ $_share_link }}" />
    <meta property="og:type"          content="article" />
    <meta property="og:title"         content="{{ $data->name }}" />
    <meta property="og:description"   content="{{ $data->description }}" />
    @if($_meta_image)
    <meta property="og:image"         content="{{ $_meta_image }}" />
    <meta property="og:image:width"   content="1200"/>
    <meta property="og:image:height"  content="628"/>
    @endif
@endsection

@section('content')
@php
$_id = $data->id;
$_user_src = asset('images/bg.png');
$_user_name = getContactName();
$_phone = getPhone();
$_address = getAddress();
$_location = '';
$_user_id = '';
$_user = $data->user;
if($_user){
	$_user_name = $_user->name;
	$_user_id = $_user->id;
	$_photo = $_user->photo;
	if($_photo){
		$_user_src = getUrlStorage("profiles/$_photo");
	}
	if($user_contact = $_user->user_contact){
		$_user_name = $_user->name;
        $_phone = $user_contact->phone;
        $_address = $user_contact->address;
        $_location = $user_contact->province->name;
    }
}
@endphp
<div class="py-4 py-xs-4">
    <div class="container">
    	<div class="row">
    		<div class="col-sm-8">
    			<div class="card">
    				<div class="card-body p-2 product"> 
    					@php
    					$_time = getNumberOfDays($data->updated_at,date('Y-m-d H:i:s'));
    					@endphp
    					<div class="product-detail clearfix mb-2">
			                <div class="d-block">
			                    <div class="product-title">
			                        <h1>{{ $data->name }}</h1>
			                    </div>
			                    <div class="product-time">
			                    	<div class="d-flex">
			                        	<div class="pr-2">
			                        		<i class="fa fa-clock-o"></i> {{ $_time }}
			                        	</div>
			                        	@if($_location)
			                        	<div>
			                        		<i class="fa fa-map-marker"></i> {{ $_location }}
			                        	</div>
			                        	@endif
			                        </div>
			                    </div>
			                    <div class="product-like">
			                    	@if(floatval($data->price) > 0 || intval($data->promotion) > 0)
		                                @if(intval($data->promotion) > 0)
		                                <a class="btn btn-primary btn-lg">
		                                    ${{ $data->promotion }}
		                                </a>
		                                
		                                <a class="text-promotion">
		                                    <del>${{ $data->price }}</del>
		                                </a>
		                                @elseif(floatval($data->price) > 0)
		                                <a class="btn btn-primary btn-lg">
		                                    ${{ $data->price }}
		                                </a>
		                                @endif
		                            @endif
			                    </div>
			                </div>
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
			                $_url_detail = route('products.detail',['id'=>$_id,'locale'=>getLang()]);
			            @endphp

			            <div class="product-image imgs-grid imgs-grid-{{$_count}} bg-white" data-url="{{ $_url_detail }}" data-toggle="modal" data-target="#modalPopup">
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

					</div>
    			</div> 
    			<div class="mt-3 mt-xs-3">
    				<div class="card">
    					<div class="card-header p-2">
    						<h3 class="mb-0 text-black">{{ __('Description') }}</h3>
    					</div>
    					<div class="card-body p-2">
    						<p>{!! nl2br($data->description) !!}</p>
    					</div>
    				</div>
    			</div>
    			<div class="mt-3 mt-xs-3">
	    			<h3 class="title">{{ __('Related Product') }}</h3>
			    	<div class="row related-product">
			    		
						@foreach($related as $row)
							@php
								$__src = '';
								foreach($row->galleries as $item){
									if($item->is_cover){
										$__src = getUrlStorage('products/'.$item->name);
										break;
									}
								}
								$__url = route('products.detail',['locale'=>getLang(),'id'=>$row->id]);
							@endphp
							<div class="col-sm-4 mb-4 mb-xs-4">
								<div class="card">
									<div class="card-cover-image">
										<a href="{{ $__url }}">
											<img class="card-img-top" src="{{ $__src }}" alt="">
										</a>
									</div>
									<div class="card-body p-2">
										<div class="d-flex">
											<div>
												<a href="{{ $__url }}">{{ $row->name }}</a>
											</div>
											@if(floatval($data->price) > 0 || intval($data->promotion) > 0)
											<div class="ml-auto">
				                                @if(intval($data->promotion) > 0)
				                                <div class="text-primary">
				                                    ${{ $data->promotion }}
				                                </div>
				                                
				                                <div class="text-primary">
				                                    <del>${{ $data->price }}</del>
				                                </div>
				                                @elseif(floatval($data->price) > 0)
				                                <div class="text-primary">
				                                	${{ $data->price }}
				                                </div>
				                                @endif
											</div>
											@endif
										</div>
									</div>
								</div>	
							</div>
						@endforeach
			    		
			    	</div>
			    </div>
    		</div>
    		<div class="col-sm-4">
    			<div class="card">
    				<div class="card-header bg-primary">
						<div class="d-inline-block">
                        	<img class="shop-owner-profile" src="{{ $_user_src }}" alt="" width="61" height="61" />
                    	</div>
                    	<div class="d-inline-block">
                        	<h4>
                        		@if($_user_id)
                        		<a class="text-white" href="{{ route('shop.index',['locale'=>getLang(),'id'=>$_user_id]) }}">{{ $_user_name }}</a>
                        		@else
                        		<span class="text-white">{{ $_user_name }}</span>
                        		@endif
                        	</h4>
                        </div>
					</div>
    				<div class="card-body account-profile">
    					<div class="menu">
    						<a><i class="fa fa-phone"></i> {{ $_phone }}</a>
							<a><i class="fa fa-map-marker"></i> {{ $_address }}</a>
						</div>
						@if(isset($_user->user_contact) && $_user->user_contact && $_user->user_contact->lat && $_user->user_contact->lng)
					    <div>
					        @php
					            $_lat = $_user->user_contact->lat;
					            $_lng = $_user->user_contact->lng;
					        @endphp
					        <div class="map">
					            <img class="img-fluid" src="{{ asset('images/map.png') }}">
					            <div class="map-overlay no-bg">
					                <div class="d-table">
					                    <div class="d-table-row">
					                        <div class="d-table-cell text-center">
					                            <a target="_blank" class="btn btn-primary" href="https://maps.google.com/maps?q={{ $_lat }},{{ $_lng }}&15">
					                            	<img width="24" class="img-fluid" src="{{ asset('images/google_map.png') }}">
					                            	{{ __('Show on map') }}
					                            </a>
					                        </div>
					                    </div>
					                </div>
					            </div>
					        </div>
					    </div>
					    @endif
					</div>
    			</div>
    		</div>
    	</div>

    </div>
</div>
@endsection

