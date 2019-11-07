<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
 * Методы этого класса связываются с конкретными маршрутами и отвечают за их обработку.
 * Благодаря этому классу, экшен теперь не содержится вторым параметром в маршруте
 * в routes/web.php, а является методом этого класса. Благодря чему можно спасти web.php
 * от перезагрузки излишним кодом, сократив маршрут в нём до одной строки.
 */
class PageController extends Controller
{
    public function about()
    {
        return view('page.about');
    }
}
