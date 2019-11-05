<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hexlet Blog - @yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="csrf-param" content="_token" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <div class="container mt-4">
            <h1>@yield('header')</h1>
            <hr>
            <div>
                @yield('content')
            </div>
        </div>
    </body>
</html>

<!--
Директива yield. Она указывает на то, куда будет вставлен конкретный контент
конкретного обработчика. В качестве аргумента, она принимает название из шаблона,
к которому макет подключен, заданное там функцией section.
-->
