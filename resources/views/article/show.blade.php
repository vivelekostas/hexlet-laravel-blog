@extends('layouts.app')

@section('title', 'Статьи')

@section('header', 'Статьи')

@section('content')
    <h1>{{$article->name}}</h1>
    <div>{{$article->body}}</div>
@endsection
