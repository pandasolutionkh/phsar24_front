
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
                @php $_label = _t('Current Password'); @endphp
                {!! Form::label('current_password', $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
                <div>
                    {!! Form::password('current_password', array('placeholder' => $_label,'class' => 'form-control required','data-required'=>$_label)) !!}
                    {!! $errors->first('current_password', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('new_password') ? 'has-error' : ''}}">
                @php $_label = _t('New Password'); @endphp
                {!! Form::label('new_password', $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
                <div>
                    {!! Form::password('new_password', array('placeholder' => $_label,'class' => 'form-control required','data-required'=>$_label)) !!}
                    {!! $errors->first('new_password', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('new_password_confirmation') ? 'has-error' : ''}}">
                @php $_label = _t('Confirm New Password'); @endphp
                {!! Form::label('new_password_confirmation', $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
                <div>
                    {!! Form::password('new_password_confirmation', array('placeholder' => $_label,'class' => 'form-control required','data-required'=>$_label)) !!}
                    {!! $errors->first('new_password_confirmation', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ _t('Save') }}</button>
            </div>



        {!! Form::close() !!}

    </div>
</div>
@endsection
