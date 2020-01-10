
@extends('layouts.user')

@section('user_menu')
    @include('users.menu',$user)
@endsection

@section('content')
    <h1 class="title">{{ __('Contact Detail') }}</h1>

    <div class="form-group">
        <label class="control-label">{{ __('Name') }}</label>
        <div class="form-control">{{ $user->name }}</div>
    </div>
    
    <div class="form-group">
        <label class="control-label">{{ __('Phone') }}</label>
        <div class="form-control">{{ $user->user_contact->phone }}</div>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Email') }}</label>
        <div class="form-control">{!! $user->user_contact ? $user->user_contact->email: '&nbsp;' !!}</div>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Address') }}</label>
        <div class="form-control">{!! $user->user_contact ? $user->user_contact->address : '&nbsp;'  !!}</div>
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Location') }}</label>
        <div class="form-control">{!! $user->user_contact ? $user->user_contact->province->name : '&nbsp;'  !!}</div>
    </div>
    @if($user->user_contact && $user->user_contact->lat && $user->user_contact->lng)
    <div>
        @php
            $_lat = $user->user_contact->lat;
            $_lng = $user->user_contact->lng;
        @endphp
        <div class="map">
            <img class="img-fluid" src="{{ asset('images/map.png') }}">
            <div class="map-overlay">
                <div class="d-table">
                    <div class="d-table-row">
                        <div class="d-table-cell text-center">
                            <a target="_blank" class="btn btn-success" href="https://maps.google.com/maps?q={{ $_lat }},{{ $_lng }}&15">
                                <img width="24" class="img-fluid" src="{{ asset('images/google_map.png') }}"> {{ __('Show on map') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
