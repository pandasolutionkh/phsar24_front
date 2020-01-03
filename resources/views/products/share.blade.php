@extends('layouts.app')

@section('meta_title')
    <title>Product | {{ $data->name }}</title>
@endsection

@section('meta')
	@php
		$_meta_image = '';
		$_share_link = route('products.detail',$data->id);
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
$_user_src = asset('images/profile.jpg');
$_user_name = getContactName();
$_phone = getPhone();
$_address = getAddress();
$_location = '';
if($_user = $data->user){
	$_photo = $_user->photo;
	$_user_src = getUrlStorage("profiles/$_photo");

	if($user_contact = $_user->userContact){
        $_user_name = $_user->name;
        $_phone = $user_contact->phone;
        $_address = $user_contact->address;
        $_location = $user_contact->province->name;
    }
}
@endphp
<div class="py-4">
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
			            @endphp

			            <div class="product-image imgs-grid imgs-grid-{{$_count}} bg-white" data-id="{{ $_id }}" data-toggle="modal" data-target="#modalPopup">
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
    			<div class="mt-3">
    				<div class="card">
    					<div class="card-header p-2">
    						<h3 class="mb-0 text-black">{{ __('Description') }}</h3>
    					</div>
    					<div class="card-body p-2">
    						<p>{!! nl2br($data->description) !!}</p>
    					</div>
    				</div>
    			</div>
    			<div class="mt-3">
	    			<h3 class="title">Related Product</h3>
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
							@endphp
							<div class="col-sm-4 mb-4">
								<div class="card">
									<div class="card-cover-image">
										<img class="card-img-top" src="{{ $__src }}" alt="">
									</div>
									<div class="card-body p-2 bg-white">
										<div class="d-flex">
											<div>
												<a href="{{ route('products.detail',$_id) }}">{{ $row->name }}</a>
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
                        	<h4 class="text-white">{{ $_user_name }}</h4>
                        </div>
					</div>
    				<div class="card-body">
    					<div class="d-flex">
							<div class="pr-1">
	                        	<i class="fa fa-phone"></i> 
	                    	</div>
	                    	<div>
	                        	{{ $_phone }}
	                        </div>
						</div>
						<div class="d-flex">
							<div class="pr-1">
	                        	<i class="fa fa-map-marker"></i> 
	                    	</div>
	                    	<div>
	                        	{{ $_address }}
	                        </div>
						</div>
					</div>
    			</div>
    		</div>
    	</div>

    </div>
</div>
@endsection

