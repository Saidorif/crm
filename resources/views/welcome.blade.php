<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>e-TECT</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('fonts/peicon/css/peicon.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css?version=1.1.1') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css?version=1.1.1') }}">

    </head>
    <body>
        <div id="app">
            <Master/>
        </div>
        <script src="{{ asset('js/app.js?version=0.0.6') }}"></script>
        <script src="{{ asset('js/print.js') }}"></script>
    </body>
</html>
