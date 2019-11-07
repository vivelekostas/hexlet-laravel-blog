<?php

// Основные страницы.
const URL_PAGE_MAIN = '/';
const URL_PAGE_ABOUT = '/about';
const URL_PAGE_ARTICLES = '/articles';

// Шаблоны к ним.
const TMPL_PAGE_MAIN = 'myWelcome';
const TMPL_PAGE_ABOUT = 'about';
const TMPL_PAGE_ARTICLES = 'articles';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Здесь вы можете зарегистрировать веб-маршруты для вашего приложения. Эти
| маршруты загружаются RouteServiceProvider в группе, которая содержит группу
| промежуточного программного обеспечения "web" Теперь создайте что-то великое!
|
| Функция Route::get($pattern, $action) задает маршрут. 1ым параметром она
| принимает адрес запрашиваемой страницы (или паттерн описывающий группу страниц).
| 2ым параметром передается обработчик/экшен (относится к слою контроллер).
| view($templateName) – глобальная функция, которая принимает на вход имя шаблона
| и возвращает его содержимое в виде строки. Затем это содержимое возвращается
| из экшена. Такой подход позволяет отделить обработку запроса, от формирования
| ответа (в данном случае HTML).
|
| При использовании контрорллера ф.Route::get принимает в себя вторым параметром строку controllerName@methodName,
| которая, как бы, вызовет обработчик, который теперь является методом класса PageController.
|
*/

Route::get(URL_PAGE_MAIN, function () {
    return view(TMPL_PAGE_MAIN);
});

//Route::get(URL_PAGE_ABOUT, function () {
//    return view(TMPL_PAGE_ABOUT);
//});

//Route::get(URL_PAGE_ARTICLES, function () {
////    $articles = App\Article::all(); //Извлекает из базы данных все статьи.
////    return view(TMPL_PAGE_ARTICLES, ['articles' => $articles]); //И выводит их в шаблон.
////});

Route::get('/about', 'PageController@about')
    ->name('about');

// Название сущности в URL во множественном числе, контроллер в единственном
Route::get('/articles', 'ArticleController@index')
    ->name('articles.index'); // имя маршрута, нужно для того чтобы не создавать ссылки руками

Route::get('/articles/{id}', 'ArticleController@show')
    ->name('articles.show');
