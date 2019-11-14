@extends('layouts.app')

@section('content')

<div class="py-4">
    <div class="container">
    @include('products.detail',['data'=>$data])
    </div>
</div>
@endsection

