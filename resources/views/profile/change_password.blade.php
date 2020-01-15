
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

    
        <div class="form-group {{ $errors->has('current_password') ? 'has-error' : ''}}">
            @php $_label = __('Current Password'); @endphp
            {!! Form::label('current_password', $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::password('current_password', array('placeholder' => $_label,'class' => 'form-control required','data-required'=>$_label)) !!}
                {!! $errors->first('current_password', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('new_password') ? 'has-error' : ''}}">
            @php $_label = __('New Password'); @endphp
            {!! Form::label('new_password', $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::password('new_password', array('placeholder' => $_label,'class' => 'form-control required','data-required'=>$_label)) !!}
                {!! $errors->first('new_password', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('new_password_confirmation') ? 'has-error' : ''}}">
            @php $_label = __('Confirm New Password'); @endphp
            {!! Form::label('new_password_confirmation', $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::password('new_password_confirmation', array('placeholder' => $_label,'class' => 'form-control required','data-required'=>$_label)) !!}
                {!! $errors->first('new_password_confirmation', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('Save') }}</button>
        </div>



    {!! Form::close() !!}

@endsection
