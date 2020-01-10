
@extends('layouts.account')

@section('content')
    <h1 class="title">{{ __('Contact Detail') }}</h1>
    
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
    

    {!! Form::model($userContact, ['method' => 'POST','enctype' => 'multipart/form-data','url' => route('profile.create_contact')]) !!}
        @php
            $_is_invalid = 'is_invalid';
        @endphp

        @php
            $_label = __('Email');
            $_field = 'email';
            $_error = ($errors->has($_field) ? $_is_invalid : '');
        @endphp
        <div class="form-group">
            {!! Form::label($_field, $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::text($_field,null, array('placeholder' => $_label,'class' => "form-control required $_error",'data-required'=>$_label)) !!}
                {!! $errors->first($_field, '<p class="invalid-feedback">:message</p>') !!}
            </div>
        </div>

        @php
            $_label = __('Phone');
            $_field = 'phone';
            $_error = ($errors->has($_field) ? $_is_invalid : '');
        @endphp
        <div class="form-group">
            {!! Form::label($_field, $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::text($_field,null, array('placeholder' => $_label,'class' => "form-control required $_error",'data-required'=>$_label)) !!}
                {!! $errors->first($_field, '<p class="invalid-feedback">:message</p>') !!}
            </div>
        </div>

        @php
            $_label = __('Address');
            $_field = 'address';
            $_error = ($errors->has($_field) ? $_is_invalid : '');
        @endphp
        <div class="form-group">
            {!! Form::label($_field, $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::text($_field,null, array('placeholder' => $_label,'class' => "form-control required $_error",'data-required'=>$_label)) !!}
                {!! $errors->first($_field, '<p class="invalid-feedback">:message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            @php
                $_label = __('Location');
                $_field = 'province_id';
                $_error = ($errors->has($_field) ? $_is_invalid : '');
            @endphp
            {!! Form::label($_field, $_label.getRequireStar(), ['class' => 'control-label'], false) !!}
            <div>
                {!! Form::select($_field,getProvinces(),null,['class' => 'form-control required','data-required'=>$_label,'placeholder'=>getPleaseSelect()]) !!}
                {!! $errors->first($_field, '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('Save') }}</button>
        </div>



    {!! Form::close() !!}

@endsection
