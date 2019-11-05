@extends('layouts.app')

@section('title', 'Статьи')

@section('header', 'Статьи')

@section('content')
    @foreach ($articles as $article)
        <h3>{{ $article->name }}</h3>
        <div>{{ $article->body }}</div>
        <br>
    @endforeach
@endsection

{{--
articles это такой лютый массив с объектами. foreach перебирает их и обращается к их свойствам.
Иногда может пригодиться метод toArray.
--}}
