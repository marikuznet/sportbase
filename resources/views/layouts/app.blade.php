<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if ( \Illuminate\Support\Facades\Auth::check() )
        <meta name="user" content="{{ \App\Models\User::self() }}"/>
    @endif

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
<!--<link href="/css/main.css" rel="stylesheet">!-->
    <script src="/js/main.js"></script>
    <script async src="https://app3.weatherwidget.org/js/?id=ww_cf927c74dfdee"></script>

    <!-- Marquiz script start -->
    <script>
        (function(w, d, s, o){
            var j = d.createElement(s); j.async = true; j.src = '//script.marquiz.ru/v2.js';j.onload = function() {
                if (document.readyState !== 'loading') Marquiz.init(o);
                else document.addEventListener("DOMContentLoaded", function() {
                    Marquiz.init(o);
                });
            };
            d.head.insertBefore(j, d.head.firstElementChild);
        })(window, document, 'script', {
                host: '//quiz.marquiz.ru',
                region: 'ru',
                id: '673b19ed8964eb00267f22cc',
                autoOpen: 10,
                autoOpenFreq: 'once',
                openOnExit: true,
                disableOnMobile: false
            }
        );
    </script>
    <!-- Marquiz script end -->
    <!--    <script src="/js/store/index.js"></script>
!-->
</head>
<body>
<div id="modals"></div>
<div id="app">
    @yield('content')
</div>
</body>
</html>
