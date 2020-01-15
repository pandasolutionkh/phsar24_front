
@extends('layouts.account')

@section('content')

<h1 class="title">{{ __('Edit Product') }}</h1> 
{!! Form::model($data, ['method' => 'PATCH','enctype' => 'multipart/form-data','url' => route('products.update', ['id'=>$data->id,'page'=>$page,'locale'=>getLang()])]) !!}                    

@include ('products.form')

{!! Form::close() !!}

@endsection


