@extends('layouts.account')

@section('content')
<chat :user="{{ getUser() }}" :product="{{ $product }}"></chat>
@endsection
@section('script')

@endsection