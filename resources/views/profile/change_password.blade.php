
@extends('layouts.account')

@section('content')
    <h1 class="title">{{ __('Change Password') }}</h1>
    
    @if ($message = Session::get('message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            {{ $message }}
        </div>
    @endif

    @if ($message = Session::get('warning'))
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            {{ $message }}
        </div>
    @endif
    

    {!! Form::model($user, ['method' => 'POST','enctype' => 'multipart/form-data','url' => route('profile.resetPassword',getLang())]) !!}

        @php
            $_is_invalid = 'is-invalid';
        @endphp

        @php
            $_label = __('Current Password');
            $_field = 'current_password';
            $_error = ($errors->has($_field) ? $_is_invalid : '');
        @endphp
        <div class="form-group {{ $errors->has('current_password') ? 'has-error' : ''}}">
            {!! Form::label($_field, $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::password($_field, array('placeholder' => $_label,'class' => "form-control required $_error",'data-required'=>$_label)) !!}
                {!! $errors->first('current_password', '<p class="invalid-feedback">:message</p>') !!}
            </div>
        </div>

        @php
            $_label = __('New Password');
            $_field = 'new_password';
            $_error = ($errors->has($_field) ? $_is_invalid : '');
        @endphp
        <div class="form-group">
            {!! Form::label($_field, $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::password($_field, array('placeholder' => $_label,'class' => "form-control required $_error",'data-required'=>$_label)) !!}
                {!! $errors->first($_field, '<p class="invalid-feedback">:message</p>') !!}
            </div>
        </div>

        @php
            $_label = __('Confirm New Password');
            $_field = 'new_password_confirmation';
            $_error = ($errors->has($_field) ? $_is_invalid : '');
        @endphp
        <div class="form-group">
            {!! Form::label($_field, $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::password($_field, array('placeholder' => $_label,'class' => "form-control required $_error",'data-required'=>$_label)) !!}
                {!! $errors->first($_field, '<p class="invalid-feedback">:message</p>') !!}
            </div>
        </div>
    
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('Save') }}</button>
        </div>



    {!! Form::close() !!}

@endsection
