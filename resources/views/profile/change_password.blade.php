
@extends('layouts.account')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>{{ _t('Change Password') }}</h3>
    </div>

    <div class="card-body">
        <div class="row">
            @if ($message = Session::get('message'))
            <div class="col-sm-12">
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    {{ $message }}
                </div>
            </div>
            @endif

            @if ($message = Session::get('warning'))
            <div class="col-sm-12">
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    {{ $message }}
                </div>
            </div>
            @endif
        </div>

        {!! Form::model($user, ['method' => 'POST','enctype' => 'multipart/form-data','url' => route('profile.resetPassword')]) !!}

        
            <div class="form-group {{ $errors->has('current_password') ? 'has-error' : ''}}">
                {!! Form::label('current_password', 'Current Password'.getRequireStar(), ['class' => 'control-label'],false) !!}
                <div>
                    {!! Form::password('current_password', array('placeholder' => 'Current Password','class' => 'form-control required','data-required'=>'current_password')) !!}
                    {!! $errors->first('current_password', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('new_password') ? 'has-error' : ''}}">
                {!! Form::label('new_password', 'New Password'.getRequireStar(), ['class' => 'control-label'],false) !!}
                <div>
                    {!! Form::password('new_password', array('placeholder' => 'New Password','class' => 'form-control required','data-required'=>'new password')) !!}
                    {!! $errors->first('new_password', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('new_password_confirmation') ? 'has-error' : ''}}">
                {!! Form::label('new_password_confirmation', 'Confirm Password'.getRequireStar(), ['class' => 'control-label'],false) !!}
                <div>
                    {!! Form::password('new_password_confirmation', array('placeholder' => 'Confirm New Password','class' => 'form-control required','data-required'=>'confirm new password')) !!}
                    {!! $errors->first('new_password_confirmation', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>



        {!! Form::close() !!}

    </div>
</div>
@endsection
