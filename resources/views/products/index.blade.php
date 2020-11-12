@extends('layouts.account')

@section('content')
<div class="mb-3">
	<div class="row">
		<div class="col-md-6">
			<h1 class="title">{{ __('Products') }}</h1>
		</div>
		<div class="col-md-6 pull-right">
			@if(checkForPost())
			<a href="{{ route('products.create',getLang()) }}" class="btn btn-md btn-primary pull-right btn-sm">
				<i class="fa fa-plus"></i> {{ __('Create') }}
			</a>
			@endif
		</div>
	</div>
	
	@if ($message = Session::get('message'))
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>

		{{ $message }}
	</div>
	@endif

	@if ($message = Session::get('warning'))
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>

		{{ $message }}
	</div>
	@endif

	{{-- start search --}}
	<form action="" class="form-group" method="get" accept-charset="utf-8">
		<div class="row">
			<!-- Search username -->
			<div class="col-lg-3 form-group">
				{{ Form::label('name', __('Name')) }}
			 	{!! Form::text('search_name', $search_name, ['class' => 'form-control','placeholder' => __('Enter your text ...')]) !!}
			</div><!-- /.col-lg-3 -->
			<div class="col-lg-3 form-group">
				{{ Form::label('cat', __('Category')) }}
			 	<div>
			        {!! Form::select('cat',getDropdownCategories(),$cat,['class' => 'form-control','placeholder'=>__('All')]) !!}
			    </div>
			</div><!-- /.col-lg-3 -->

			<div class="col-lg-3 form-group">
				{{ Form::label('sub', __('Sub Category')) }}
			 	<div>
			        {!! Form::select('sub',getSubCats(),$sub,['class' => 'form-control','placeholder'=>__('All')],getSubCatAttributes()) !!}
			    </div>
			</div><!-- /.col-lg-3 -->

			<div class="col-lg-3">
				<label>&nbsp;</label>
				<button class="btn btn-primary btn-block" type="submit">
		        	<i class="glyphicon glyphicon-search"></i> {{ __('Search') }}
		        </button>
			</div>

		</div><!-- /.row -->
    </form>
	{{-- end start search --}}

	<div class="row wrapper-row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="w-45px">{{ __('No') }}</th>
							<th class="w-55px">{{ __('Photo') }}</th>
							<th>{{ __('Name') }}</th>
							<th class="w-70px">{{ __('Price') }}</th>
							<th class="w-85px">{{ __('Promotion') }}</th>
							<th>{{ __('Category') }}</th>
							<th>{{ __('Sub Category') }}</th>
							<th class="w-150px">{{ __('Created At') }}</th>
							<th class="text-right w-85px">{{ __('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = $data->firstItem(); ?>
						@foreach ($data as $key => $item)
						<tr>
							<td>{{ $i++ }}</td>
							<td>
								@if ($item->galleries)
									@php
										$_src = '';
										foreach($item->galleries as $_item){
											if($_item->is_cover){
												$_src = getUrlStorage('products/'.$_item->name);
												break;
											}
										}
									@endphp
									@if($_src)
									<img class="width-40px" src="{{ $_src }}" alt=""/>
									@endif
								@else
								<i class="fa fa-image fa-2x"></i>
								@endif
							</td>
							<td>{{ $item->name }}</td>
							<td>{{ ($item->price ? '$'.$item->price : '') }}</td>
							<td>{{ ($item->promotion ? '$'.$item->promotion : '') }}</td>
							<td>{{ $item->sub_category->category->name }}</td>
							<td>{{ $item->sub_category->name }}</td>
							<td>{{ $item->created_at }}</td>
							
							<td class="text-right">
								<a data-toggle="tooltip" data-placement="left" title="{{ __('Edit') }}" class="btn btn-info btn-sm" href="{{ route('products.edit',['id'=>$item->id,'page'=>$page,'locale'=>getLang()]) }}">
									<i class="fa fa-edit"></i>
								</a>
								
								{!! Form::open(['method' => 'DELETE','url' => route('products.destroy',['id'=>$item->id,'page'=>$page,'locale'=>getLang()]),'style'=>'display:inline','class'=>'delete',]) !!}
								<button title="{{ __('Delete') }}" type="button" class="btn btn-danger btn-sm some-class deletet" type='submit' data-toggle="modal" data-target="#confirmDelete" data-title="Delete Product" data-message='Are you sure you want to delete this Item ?'>
									<i class="fa fa-remove"></i>
								</button>
								{!! Form::close() !!}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

				{!! $data->appends($_GET)->links(); !!}
			</div>

		</div>

	</div>

   
</div>
@endsection

@section('script')
<script type="text/javascript">
  var _ele_cat = 'select[name="cat"]';
  var _ele_sub = 'select[name="sub"]';
  
  function updateSub(p_cat){
    p_cat = (typeof p_cat != '' ? p_cat : '');
    var _dis = 'disabled';
    if(p_cat != ''){
        $(_ele_sub+' option[value!=""]').attr(_dis, _dis);
        $(_ele_sub+' option[data-category="'+p_cat+'"]').removeAttr(_dis);
    }else{
        $(_ele_sub+' option[value!=""]').removeAttr(_dis);
    }
    updateSelect2($(_ele_sub));
  }

  $(document).ready(function(){
    var _cat = $(_ele_cat).val();
    updateSub(_cat);
  });

  $(document).on('change',_ele_cat,function(){
    var _id = $(this).val();
    updateSub(_id);
  });

</script>
@endsection
