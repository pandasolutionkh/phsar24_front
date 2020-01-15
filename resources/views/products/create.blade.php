@extends('layouts.account')

@section('content')

<h1 class="title">{{ __('Create Product') }}</h1>
{!! Form::open(array('url' => route('products.store',getLang()),'method'=>'POST','enctype' => 'multipart/form-data')) !!}

 @include ('products.form')

{!! Form::close() !!}

@endsection

