<?php
//// Пример сортировки массива со статьями по опубликованности и рейтингу, и вывод
//// его в шаблон. С использованием контроллера. ============================СТАРТ
//// BEGIN (write your solution here)
//Route::get('/rating', 'RatingController@index');
//// END
//
//// BEGIN (write your solution here)
//namespace App\Http\Controllers;
//use App\Article;
//class RatingController extends Controller
//{
//    public function index()
//    {
//        //об-кт.класса коллекция с коллекцией об-ов.класса статья
//        $articles = Article::all();
//        // фильтрует только опубликованные статьи по кол-ву лайков
//        $publishedArticles = $articles->where('state', 'published')
//                                      ->sortByDesc('likes_count');
//        //передаёт их в шаблон
//        return view('rating.index', ['sortedArticles' => $publishedArticles]);
//    }
//}
//// END
//
//{{-- BEGIN (write your solution here) --}}
//@extends('layouts.app')
//
//@section('content')
//    @foreach ($sortedArticles as $article)
//        <h3>{{ $article->name }}</h3>
//        <div>{{ $article->body }},<br>лайки: {{$article->likes_count}}</div>
//        <br>
//@endforeach
//@endsection
//{{-- END --}}

////И табличный вариант вывода:
//{{-- BEGIN --}}
//@extends('layouts.app')
//
//@section('content')
//<h1>Рейтинг</h1>
//    <div>
//        <table>
//            <thead>
//                <tr>
//                    <td>Название</td>
//                    <td>Число лайков</td>
//                </tr>
//            </thead>
//            <tbody>
//@foreach($articles as $article)
//                    <tr>
//                        <td>{{$article->name}}</td>
//                        <td>{{$article->likes_count}}</td>
//                    </tr>
//@endforeach
//            </tbody>
//        </table>
//    <div>
//@endsection
//{{-- END --}}
//=========================================================================КОНЕЦ

//DB_DATABASE=laravel переменная из .env (переменная окружения)

// Передаёт массив в шаблон================================================СТАРТ
//$team = [
//    ['name' => 'Hodor', 'position' => 'programmer'],
//    ['name' => 'Joker', 'position' => 'CEO'],
//    ['name' => 'Elvis', 'position' => 'CTO'],
//];
//
//Route::get('/about', function () use ($team) {
//    // BEGIN (write your solution here)
//    return view('about', ['team' => $team]);
//    // END
//});
//
//// И вывод в шаблоне
//@foreach ($team as $user)
//    <p>Это {{ $user['name'] }} и он {{ $user['position'] }}</p>
//@endforeach
//=========================================================================КОНЕЦ
