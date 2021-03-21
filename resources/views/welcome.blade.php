<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <script src="https://js.pusher.com/4.3/pusher.min.js"></script>

        <script src="https://kit.fontawesome.com/66b016d0c4.js" crossorigin="anonymous"></script>
        
    </head>
    <body>
        <div id="app">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <stream csrf="{{csrf_token()}}" authEndpoint="{{ url(request()->path().'/auth') }}"><Stream>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>
