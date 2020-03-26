<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TEST</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css?version=1.1.1') }}">
        <link href="{{ asset('fonts/peicon/css/peicon.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <Master/>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
