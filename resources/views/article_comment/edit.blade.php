@extends('layouts.app')

@section('title', 'Статьи')

@section('header', 'Редактировать комментарий')

@section('content')
    <h1>{{$article->name}}</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- BEGIN --}}
    {{ Form::model($comment, ['method' => 'PATCH', 'url' => route('articles.comments.update', [$article, $comment])]) }}
        {{ Form::textarea('content') }}
        {{ Form::submit('Update') }}
    {{ Form::close() }}
    {{-- END --}}
@endsection
