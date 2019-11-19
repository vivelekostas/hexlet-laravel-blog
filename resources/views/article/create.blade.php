@extends('layouts.app')

@section('title', 'Создание Статьи')

@section('header', 'Создание Статьи')

@section('content')
{{--    <div class="form-group">--}}
        {{ Form::model($article, ['url' => route('articles.store')]) }}
            @include('article.form')
            {{ Form::submit('Создать') }}
        {{ Form::close() }}
{{--    </div>--}}
@endsection
