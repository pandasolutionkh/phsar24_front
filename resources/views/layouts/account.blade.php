<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <link rel="stylesheet" href="/css/animate.css"/>
    @yield('style')
    @php
        $_v = '1.0.2';
    @endphp
    <link rel="stylesheet" href="/css/nprogress.css"/>
    <link rel="stylesheet" href="/css/app.css?v={!! $_v !!}"/>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        var base_url = "{{ url('/') }}";
    </script>
</head>
<body>
    @include('layouts.modal')
    <div id="app">
        @include('layouts.nav')
        <main>
            <div class="py-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3>{{ _t('Menu') }}</h3>
                                </div>

                                <div class="card-body account-profile">
                                    <div class="menu">
                                        <a href="{{ route('profile.index') }}">
                                            {!! _t('Profile') !!}
                                        </a>
                                        <a href="{{ route('histories.index') }}">
                                            {!! _t('History') !!}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('layouts.footer')
    </div>

    @include('layouts.popup')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="/js/nprogress.js"></script>
    <script src="/js/app.js?v={!! $_v !!}"></script>
    <script src="/js/custom.js?v={!! $_v !!}"></script>
    @yield('script')

    @if(ENV('APP_ENV') == 'production')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120563437-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-120563437-1');
    </script>
    @endif
</body>
</html>
