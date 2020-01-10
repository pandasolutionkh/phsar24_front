@extends('layouts.app')

@section('content')
<div class="py-4">
	<div class="container">
		<h1 class="title">{{ __('About US') }}</h1>
		{!! getAboutUs() !!}
	</div>
</div>
@endsection