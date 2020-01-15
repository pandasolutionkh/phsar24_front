
@extends('layouts.account')

@section('content')

<h1 class="title">{{ __('Profile') }}</h1>
@if ($message = Session::get('message'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>

    {{ $message }}
</div>
@endif

{!! Form::model($user, ['method' => 'POST','enctype' => 'multipart/form-data','url' => route('profile.update',getLang())]) !!}

@include ('profile.form')

{!! Form::close() !!}

@endsection
