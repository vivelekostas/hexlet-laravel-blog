@extends('layouts.app')

@section('title', 'Обновление')

@section('header')
    Обновление Статьи {{$article->name}}
@endsection

@section('content')
{{ Form::model($article, ['url' => route('articles.update', $article), 'method' => 'PATCH']) }}
@include('article.form')
{{ Form::submit('Обновить') }}
{{ Form::close() }}
@endsection
