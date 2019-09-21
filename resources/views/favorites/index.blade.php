
@extends('layouts.app')

@section('content')

<div class="py-4">
    <div class="container">
    	<h1 class="title">{{ _t('Favorite') }}</h1>
		@if ($message = Session::get('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ $message }}
		</div>
		@endif

		<div class="make-columns"> 
        @foreach($products as $key => $data)
            @include ('products.item',$data)
        @endforeach
        </div>
   </div>
</div>
@endsection
