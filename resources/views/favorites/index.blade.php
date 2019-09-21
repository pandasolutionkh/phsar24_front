
@extends('layouts.account')

@section('content')

  <div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-6">
				<h3 class="text-default">
					{{ _t('Favorite') }}
				</h3>
			</div>
		</div>
	</div>

	<div class="card-body">
		@if ($message = Session::get('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ $message }}
		</div>
		@endif

		<div class="make-columns"> 
        @foreach($products as $key => $_entity)
            @php
                $data = $_entity;
            @endphp
            @include ('products.item',$data)
        @endforeach
        </div>
   </div>
</div>
@endsection
