@php
    $_user_src = asset('images/bg.png');
    if($_photo = $user->photo){
        $_user_src = getUrlStorage('profiles/'.$_photo);
    }
    $_user_name = $user->name;
@endphp
<div class="card">
    <div class="card-header bg-primary">
        <div class="d-inline-block">
            <img class="shop-owner-profile" src="{{ $_user_src }}" alt="" width="61" height="61" />
        </div>
        <div class="d-inline-block">
            <h4 class="text-white">{{ $_user_name }}</h4>
        </div>
    </div>
    <div class="card-body account-profile">
        <div class="menu">
            <a href="{{ route('shop.index',['locale'=>getLang(),'id'=>$user->id]) }}">
                {!! __('Product') !!}
            </a>
            <a href="{{ route('shop.contact',['locale'=>getLang(),'id'=>$user->id]) }}">
                {!! __('Contact Detail') !!}
            </a>
        </div>
    </div>
</div>