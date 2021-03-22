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
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-2 text-center">
                                <img src="{{ asset('uni.png') }}" style="max-width: 120px;" alt="...">
                                </div>
                                <div class="col-md-10">
                                <div class="card-body text-center">
                                    <h3 class="card-title">UNIVERSIDAD NACIONAL DE INGENIERIA</h3>
                                    <p class="card-text">FACULTAD DE CIENCIAS</p>
                                    <p class="card-text">EXAMEN FINAL - APRENDIZAJE AUTOMATICO Y MINERIA DE DATOS</p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <strong>Cálculo automático mediante redes neuronales del tiempo de transmisión de un slogan en RPP</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <stream csrf="{{csrf_token()}}" authEndpoint="{{ url(request()->path().'/auth') }}"><Stream>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Integrantes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Jeancarlos Casquín Aguilar</td>
                                        </tr>
                                        <tr>
                                            <td>Jhony Díaz Quispe</td>
                                        </tr>
                                        <tr>
                                            <td>Jose Luis Julca Huarca</td>
                                        </tr>
                                        <tr>
                                            <td>Luis Vigo Vilca</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
