@extends('layouts.account')

@section('content')

<h1 class="title">Create Product</h1>
{!! Form::open(array('route' => 'products.store','method'=>'POST','enctype' => 'multipart/form-data')) !!}

 @include ('products.form')

{!! Form::close() !!}

@endsection

