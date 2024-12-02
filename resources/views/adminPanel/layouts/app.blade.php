<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if ( \Illuminate\Support\Facades\Auth::check() )
        <meta name="user" content="{{ \App\Models\User::self() }}"/>
    @endif

    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="{{ mix('css/admin/admin.css') }}" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ mix('js/admin/admin.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.js"></script>

    @yield('third_party_stylesheets')

    @stack('page_css')


</head>
<body>
<div id="app">
    @include('adminPanel.layouts.sidebar')

    <div class="c-wrapper">
        <header class="c-header c-header-light c-header-fixed">
            @include('adminPanel.layouts.header')
        </header>

        <div class="c-body">
            <main class="c-main" style="padding:0">
                @yield('content')
            </main>
        </div>

        <footer class="c-footer">
            <div><a href="/">Спортбаза.рф</a> © 2022 Спортбаза.рф</div>
            <div class="mfs-auto">Powered by&nbsp;<a href="https://coreui.io/">Спортбаза</a></div>
        </footer>
    </div>

    @yield('third_party_scripts')

    @stack('page_scripts')
</div>

</body>
</html>
