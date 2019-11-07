@extends('layouts.app')

@section('title', 'Статьи')

@section('header', 'Статьи')

@section('content')
    @foreach($articles as $article)
        <a href="/articles/{{$article->id}}"><h3>{{$article->name}}</h3></a>
        {{-- Str::limit – функция-хелпер, которая обрезает текст до указанной длины --}}
        {{-- Используется для очень длинных текстов, которые нужно сократить --}}
        <div>{{Str::limit($article->body, 200)}}</div>
        <br>
    @endforeach
    <div>
        {{-- красивый вывод пейджинга --}}
        {{ $articles->links() }}
    </div>
@endsection

{{--
articles это такой лютый массив (коллекция) с объектами. foreach перебирает их и обращается к их свойствам.
Иногда может пригодиться метод toArray.
--}}
