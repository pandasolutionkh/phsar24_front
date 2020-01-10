@extends('layouts.app')

@section('content')
<div class="py-4">
	<div class="container">
		<h1 class="title">{{ __('Terms & Conditions') }}</h1>
		{!! getTermCondition() !!}
	</div>
</div>
@endsection