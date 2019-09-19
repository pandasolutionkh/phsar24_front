
@extends('layouts.account')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>{{ _t('Your Profile') }}</h3>
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
        </div>

        {!! Form::model($user, ['method' => 'POST','enctype' => 'multipart/form-data','url' => route('profile.update')]) !!}

        @include ('profile.form')

        {!! Form::close() !!}

    </div>
</div>
@endsection
