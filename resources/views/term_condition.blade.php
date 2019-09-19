@extends('layouts.app')

@section('content')
<div class="py-4">
	<div class="container">
		<h1 class="title">{{ _t('Terms & Conditions') }}</h1>
		{!! getTermCondition() !!}
	</div>
</div>
@endsection