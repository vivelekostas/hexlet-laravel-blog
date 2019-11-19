@extends('layouts.app')

@section('title', 'Статьи')

@section('header', 'Статьи')

@section('content')
    <div>
        {{Form::open(['url' => route('articles.index'), 'method' => 'GET'])}}
        {{Form::text('q', $q)}}
        {{Form::submit('Найти!')}}
        {{Form::close()}}
    </div>
    <br>
    @foreach($articles as $article)
        {{--пример использования именованного маршрута для динамического маршрута--}}
        <a href="{{ route('article', $article) }}"><h3>{{$article->name}}</h3></a>
        {{-- Str::limit – функция-хелпер, которая обрезает текст до указанной длины --}}
        {{-- Используется для очень длинных текстов, которые нужно сократить --}}
        <div>{{Str::limit($article->body, 200)}}<br>
            <a href="{{ route('articles.edit', $article->id) }}"><i>(edit)</i></a>
            <a href="{{ route('articles.destroy', $article->id) }}" data-confirm="Вы уверены, что хотите удалить эту статью, сеньор?" data-method="delete" rel="nofollow">Удалить</a>
        </div>
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
