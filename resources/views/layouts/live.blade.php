<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <title>{{ config('app.name') }}</title>
    <script src="/js/lib/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    @yield('style')
    <link rel="stylesheet" href="/css/live.css"/>
    <link rel="shortcut icon" href="/favicon.ico"/>

    <meta property="fb:app_id"        content="{{ ENV('FACEBOOK_APP_ID') }}"/>
    <meta property="og:site_name"     content="{{ ENV('APP_NAME') }}">
    <meta property="og:url"           content="http://www.globalive.live" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Globalive" />
    <meta property="og:description"   content="Globalive" />
    <meta property="og:image"         content="{{ asset('globalive.jpg') }}" />
    <meta property="og:image:width"   content="200"/>
    <meta property="og:image:height"  content="200"/>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        var base_url = "{{ url('/') }}";
    </script>
</head>
<body>
    @yield('content')

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
