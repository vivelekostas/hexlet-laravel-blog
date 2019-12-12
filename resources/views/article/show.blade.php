@extends('layouts.app')

@section('title', 'Статьи')

@section('header', 'Статьи')

@section('content')
    <h1>{{$article->name}}</h1>
    <div>{{$article->body}}</div>
    <br>

    <h3>Комментарии</h3>

    @foreach($article->comments as $comment)
        <div>{{$comment->content}}</div>
        <div>
            <a href="{{ route('articles.comments.edit', [$article, $comment]) }}"><i>(еdit)</i></a>
            /
            <a href="{{ route('articles.comments.destroy', [$article, $comment]) }}" data-confirm="Are you sure?" data-method="delete">Delete</a>
        </div>
    @endforeach

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ Form::model($newComment, ['url' => route('articles.comments.store', $article)]) }}
        {{ Form::textarea('content') }}
        {{ Form::submit('Добавить') }}
    {{ Form::close() }}

@endsection
