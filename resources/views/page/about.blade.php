<!-- Хранится в resources/views/about.blade.php -->
@extends('layouts.app')

<!-- Секция, содержимое которой обычный текст. -->
@section('title', 'О блоге')

@section('header', 'О Блоге')

<!-- Секция, содержащая HTML блок. Имеет открывающую и закрывающую часть. -->
@section('content')
    <p>
        Эксперименты с Ларавелем на Хекслете.<br>
        Господи, помоги!<br>
        Моей любимой Мурче посвящается.<br>
        31 октября 2019 года.
    </p>
@endsection

<!--
Директива extends указывает на макет, внутрь которого должны попасть данные
из текущего шаблона. В эту директиву передается путь относительно директории
resources/views. Обратите внимание что вместо / используется точка.
Далее идут секции. У каждой секции есть имя, благодаря которому можно точечно
управлять местом ее отображения через ф.yield в самом макете. Выше создаются
две секции content и title. Одна из них отображается в теге <title>, другая
внутри <body> и является центральной контентной частью страницы.
-->