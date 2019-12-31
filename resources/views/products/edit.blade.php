
@extends('layouts.account')

@section('content')

<h1 class="title">Edit Product</h1> 
{!! Form::model($data, ['method' => 'PATCH','enctype' => 'multipart/form-data','url' => route('products.update', ['id'=>$data->id,'page'=>$page])]) !!}                    

@include ('products.form')

{!! Form::close() !!}

@endsection


