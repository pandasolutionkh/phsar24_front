
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
    

    {!! Form::model($userContact, ['method' => 'POST','enctype' => 'multipart/form-data','url' => route('profile.create_contact',getLang())]) !!}
        @php
            $_is_invalid = 'is-invalid';
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
                {!! Form::select($_field,getProvinces(),null,['class' => "form-control required $_error",'data-required'=>$_label,'placeholder'=>getPleaseSelect()]) !!}
                {!! $errors->first($_field, '<p class="invalid-feedback">:message</p>') !!}
            </div>

            {!! Form::hidden('lat',null) !!}
            {!! Form::hidden('lng',null) !!}
        </div>

        <div class="form-group" style="height: 450px;">
            <div id="map" style="height: 100%"></div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('Save') }}</button>
        </div>



    {!! Form::close() !!}

@endsection

@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQ6B07Nbbe2tmrr35bz0rc5CpleZm1mkA">
</script>
<script type="text/javascript">
    var frm_lat = $('[type="hidden"][name="lat"]');
    frm_lat = (frm_lat.length ? frm_lat.val() : '');
    var frm_lng = $('[type="hidden"][name="lng"]');
    frm_lng = (frm_lng.length ? frm_lng.val() : '');
    var lat = 11.555551109030914;
    lat = (frm_lat ? frm_lat : lat);
    var lng = 104.9142507598633
    lng = (frm_lng ? frm_lng : lng);

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(lat, lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    function getLocation(latitude,longitude) {
        var _pos = {
            'coords':{
                'latitude':latitude,
                'longitude':longitude
            }
        };
        if(latitude && longitude){
            showPosition(_pos);
        }else{
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                showPosition(_pos);    
            }    
        }
        
    }

    function showPosition(position) {
        var _lat = position.coords.latitude;
        var _lng = position.coords.longitude;
        setLatLong(_lat, _lng);
        var _marker_option = {
            position: new google.maps.LatLng(_lat, _lng),
            draggable: true
        };
        var myMarker = new google.maps.Marker(_marker_option);

        google.maps.event.addListener(myMarker, 'dragend', function(evt) {
            var _laln = evt.latLng;
            setLatLong(_laln.lat(), _laln.lng());
        });
        map.setCenter(myMarker.position);
        myMarker.setMap(map);
    }

    function setLatLong(p_lat,p_lng){
        if($('[type="hidden"][name="lat"]').length){
            $('[type="hidden"][name="lat"]').val(p_lat);
        }

        if($('[type="hidden"][name="lng"]').length){
            $('[type="hidden"][name="lng"]').val(p_lng);
        }
    }
    getLocation(lat,lng);
</script>
@endsection
