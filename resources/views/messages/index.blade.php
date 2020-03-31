@extends('layouts.account')

@section('content')
<chat-app :user="{{ getUser() }}"></chat-app>
@endsection
@section('script')

@endsection