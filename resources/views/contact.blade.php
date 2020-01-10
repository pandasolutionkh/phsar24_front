@extends('layouts.app')

@section('content')
<?php
	$setting = getSetting();
?>
<div class="py-4">
	<div class="container">
		@if ($message = Session::get('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ $message }}
		</div>
		@endif
		
		<h1 class="title">{{ __('Contact US') }}</h1>
		<div class="row">
			<div class="col-md-4">
				<div class="card mb-4">
					<div class="card-body">
					{{ __('Email') }}: {{ isset($setting['email']) && $setting['email'] ? $setting['email']:'info@globalive.live' }}
					</div>
				</div>
				<div class="card mb-4">
					<div class="card-body">
					{{ __('Phone') }}: {{ isset($setting['phone']) && $setting['phone'] ? $setting['phone']:'096 951 5555' }}
					</div>
				</div>
				<div class="card mb-4">
					<div class="card-body">
					{{ __('Address') }}: {{ isset($setting['address']) && $setting['address'] ? $setting['address']:"#100E1, St.164, Sangkat Orussei 2, Khan 7Makara, Phnom Penh, Kingdom of Cambodia" }}
					</div>
				</div>
			</div>

			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
					{!! Form::open(array('route' => 'contact.store','method'=>'POST','id'=>'frmContact')) !!}
						<div class="form-group">
				            {!! Form::label('subject', __('Subject').getRequireStar(), ['class' => 'control-label'],false) !!}
				            <div>
				                {!! Form::text('subject', null, array('placeholder' => __('Subject'),'class' => 'form-control required'.($errors->has('subject') ? ' is-invalid' : '' ),'data-required'=>'subject')) !!}
				                {!! $errors->first('subject', '<p class="invalid-feedback">:message</p>') !!}
				            </div>
			        	</div>

			        	<div class="form-group">
				            {!! Form::label('email', __('Email').getRequireStar(), ['class' => 'control-label'],false) !!}
				            <div>
				                {!! Form::text('email', null, array('placeholder' => __('Email'),'class' => 'form-control required'.($errors->has('email') ? ' is-invalid' : '' ),'data-required'=>'email')) !!}
				                {!! $errors->first('email', '<p class="invalid-feedback">:message</p>') !!}
				            </div>
			        	</div>

			        	<div class="form-group">
				            {!! Form::label('message', __('Message').getRequireStar(), ['class' => 'control-label'],false) !!}
				            <div>
				                {!! Form::textarea('message', null, array('placeholder' => __('Message'),'class' => 'form-control required'.($errors->has('message') ? ' is-invalid' : '' ),'data-required'=>'message')) !!}
				                {!! $errors->first('message', '<p class="invalid-feedback">:message</p>') !!}
				            </div>
			        	</div>
			        	<div>
					        <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> {{ __('Send') }}</button>
					    </div>
					{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection