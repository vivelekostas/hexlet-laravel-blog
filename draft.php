<?php

// Пример простой формы из шаблона, особенно интересен тут пример
// select и валидация к нему из метода контроллера==================================СТАРТ

//{{ Form::model($category, ['url' => route('article_categories.store')]) }}
//    {{ Form::label('name', 'Название') }}
//    {{ Form::text('name') }}<br>
//    {{ Form::label('description', 'Описание') }}
//    {{ Form::textarea('description') }}<br>
//    {{ Form::select('state', ['draft' => 'Черновик', 'published' => 'Опубликован']) }}<br>
//    {{ Form::submit('Создать') }}
//    {{ Form::close() }}

//$this->validate($request, [
//    'name' => 'required|unique:articles',
//    'description' => 'required|min:10',
//    // 'state' => 'alpha'
//    'state' => 'in:draft,published'
//]);

//==================================================================================ФИНИШ


//Пример обработичка для вывода списка статей и обработки поискового запроса по ним.
//Это моё решение, в приложении я оставил более интересное решение с hexlet=========СТАРТ

//public function index(Request $request)
//{
    // $q = $request->input('q', ''); //присв-ет значение по умолчанию для строки поиска
    //// Если от пользователя пришел поисковый запрос то:
    // if ($request->input()) {
    ////Присв-ет значение из пользо-кова ввода для строки поиска
    //     $q = $request->input('q');
    //// Фильтрует по слову, встречающемуся в названии статьи.
    //     $articles = Article::where('name', 'ilike', "%{$q}%")->get();
    //     return view('article.index', compact('articles', 'q'));
    // }

    // $articles = Article::All();
    // return view('article.index', compact('articles', 'q'));
//}

//===========================================================================КОНЕЦ

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


// На всякий случай пример контроллера ArticleController в связи тестом
// ресурсного роутинга=====================================================СТАРТ

//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//use App\Article;
//use App\Http\Requests\ArticleValidateRequest;
//
//class ArticleController extends Controller
//{
//
//    /**
//     * Возвращает список всех статей с учётом пейджинга. Если же сюда приходит поисковая
//     * форма, то из неё ($request) извлекаются данные, и статьи извлекаются уже с определённой
//     * фильтрацией - согласно запросу.
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     */
//    public function index(Request $request)
//    {
//        $q = $request->input('q'); // Извлекает значение по указанному ключу (если есть).
//
//        // Like оказывает огромное влияние на производительность. Используйте их осторожно. Изучите индексы
//        // и полнотекстовый поиск.
//        // Если $q - true (т.е НЕ пустое), то присв-ется 1ое значение, а еси false (null/пустое) то 2ое.
//        // В 1ом значении про-ит фильтрация по слову, встречающемуся в названии статьи с учётом пагинации.
//        // q передаётся 2ым пар-ом, чтобы строка поиска не оставалась пустой после выполнения.
//        $articles = $q ? Article::where('name', 'like', "%{$q}%")->paginate(3) : Article::paginate(3);
//        return view('article.index', compact('articles', 'q'));
//    }
//
//    /**
//     * Вывод формы.
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     */
//    public function create()
//    {
//        // Передаем в шаблон вновь созданный объект. Он нужен для вывода формы через Form::model
//        $article = new Article();
////        dd($article);
//        return view('article.create', compact('article'));
//    }
//
//    /**
//     * Обработчик формы создания статьи. Сначала проверяются данные формы с применением Form Request
//     * (ArticleValidateRequest) и если форма не пройдет проверку, то этот метод даже не начнёт исполняться,
//     * а если всё хорошо, то создаётся ноый об.класса статья, в него записываются данные из формы
//     * и он сохраняется в БД. Form Request позволяет избежать дублирования кода за счёт того, что берёт
//     * валидациюна себя, позволяя удалить её из методов контроллера.
//     * Здесь нам понадобится объект запроса, для извлечения данных.
//     * @param ArticleValidateRequest $request
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function store(ArticleValidateRequest $request)
//    {
//        // validate - тут работает ArticleValidateRequest, точнее он ещё раньше срабатывает)
//
//        $article = new Article();
//        // Заполнение статьи данными из формы. Метод all() возвращает все данные формы,
//        // а метод fill($params) выполняет установку сразу всех значений через передачу
//        // ассоциативного массива.
//        $article->fill($request->all());
//        // При ошибках сохранения возникнет исключение
//        $article->save();
//
//        // Редирект на указанный маршрут с добавлением флеш сообщения
//        \Session::flash('flash_message', 'Новая статья успешно создана, милорд!');
//        return redirect()
//            ->route('articles.index');
//    }
//
//    /**
//     * @param $id  определенный в маршруте, приходит в обработчик как аргумент.
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     */
//    public function show($id)
//    {
//        // Специальная ф., которая в случае отсутсвия искомого элемента
//        // вернёт обработанное исключение, в отличие от ф.find.
//        $article = Article::findOrFail($id);
//        return view('article.show', compact('article'));
//    }
//
//    /**
//     * @param $id определенный в маршруте, приходит в обработчик как аргумент.
//     * Мы не создаем сущность с нуля, для передачи в форму, как при создании
//     * новой статьи, а извлекаем ее из базы.
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     */
//    public function edit($id)
//    {
//        $article = Article::findOrFail($id);
//        return view('article.edit', compact('article'));
//    }
//
//    /**
//     * @param Request $request - из него извлекаются данные формы.
//     * @param $id определенный в маршруте, приходит в обработчик как аргумент.
//     * Обработчик, который проверит данные формы и сохранит обновления, сделая редирект
//     * на маршрут списка статей, или выдаст ошибку. Сначала находиться конкретная запись в БД по id,
//     * затем происходит валидация данных из пришедшей формы с исключением найденной записи. А потом
//     * найденная запись просто перезавписывается.
//     * @return \Illuminate\Http\RedirectResponse
//     * @throws \Illuminate\Validation\ValidationException
//     */
//    public function update(Request $request, $id)
//    {
//        $article = Article::findOrFail($id);
//        $this->validate($request, [
//            // тут пока без ArticleValidateRequest)
//            // У обновления немного измененная валидация. В проверку уникальности добавляется
//            // название поля и id текущего объекта.
//            // Если этого не сделать, Laravel будет ругаться на то что имя уже существует
//            'name' => 'required|unique:articles,name,' . $article->id,
//            'body' => 'required|min:10',
//        ]);
//
//        $article->fill($request->all());
//        $article->save();
//        \Session::flash('flash_message', 'Милорд, эта статья успешно обновлена!');
//        return redirect()
//            ->route('articles.index');
//    }
//
//    /**
//     * Не забывайте про авторизацию -Удаление должно быть
//     * доступно только тем, кто может его выполнять.
//     * @param $id для поиска сущности
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function destroy($id)
//    {
//        // DELETE идемпотентный метод, поэтому результат операции всегда один и тот же
//        $article = Article::find($id);
////        dd($article->name);
//        $name = $article->name;
//        if ($article) {
//            $article->delete();
//        }
//
//        \Session::flash('flash_message', 'Милорд, статья: ' . $name . ' удалена успешно!');
//        return redirect()->route('articles.index');
//    }
//
//}
//
//// И маршруты к ним из web.php
//
//// Для списка статьей, поискового запроса, редиректа после создания, обновления и удаления.
//// Название сущности в URL во множественном числе, контроллер в единственном.
//Route::get('/articles', 'ArticleController@index')
//    ->name('articles.index'); // Имя маршрута, нужно для того чтобы не создавать ссылки руками.
//
//// Для формы создания статьи.
//Route::get('/articles/create', 'ArticleController@create')
//    ->name('articles.create');
//
//// POST запрос для формы создания статьи.
//Route::post('/articles', 'ArticleController@store')
//    ->name('articles.store');
//
//// Для конкретной статьи.
//Route::get('/articles/{id}', 'ArticleController@show')
//    ->name('article');
//
//// Для вывода формы обновления статьи.
//Route::get('/articles/{id}/edit', 'ArticleController@edit')
//    ->name('articles.edit');
//
//// Для обработки отправленной формы обновления статьи.
//Route::patch('/articles/{id}', 'ArticleController@update')
//    ->name('articles.update');
//
//// Для удаления статьи.
//Route::delete('/articles/{id}', 'ArticleController@destroy')
//    ->name('articles.destroy');

// И на всякий случай, из любви к первым моим записям, пример экшена в маршруте:

//Route::get(URL_PAGE_ABOUT, function () {
//    return view(TMPL_PAGE_ABOUT);
//});

//Route::get(URL_PAGE_ARTICLES, function () {
////    $articles = App\Article::all(); //Извлекает из базы данных все статьи.
////    return view(TMPL_PAGE_ARTICLES, ['articles' => $articles]); //И выводит их в шаблон.
////});

//==============================================================================КОНЕЦ

// Пример контроллера для комметариев===========================================НАЧАЛО

//namespace App\Http\Controllers;
//
//use App\Article;
//use App\ArticleComment;
//use Illuminate\Http\Request;
//
//class ArticleCommentController extends Controller
//{
//
//    public function store(Request $request, Article $article)
//    {
//        $this->validate($request, [
//            'content' => 'required|min:10'
//        ]);
//        $comment = new articleComment();
//        $comment->content = $request->input('content');
//        $comment->article_id = $article->id;
//        $comment->save();
//        return redirect()->route('articles.show', $article);
//    }
//
//    public function edit(Article $article, ArticleComment $comment)
//    {
//        return view('article_comment.edit', compact('article', 'comment'));
//    }
//
//    public function update(Request $request, Article $article, ArticleComment $articleComment, $comment)
//    {
//        $updateComment = ArticleComment::findOrFail($comment);
//        $this->validate($request, [
//            'content' => 'required|min:10' . $articleComment->id
//        ]);
//
//        $updateComment->fill($request->all());
//        $updateComment->save();
//        return redirect()->route('articles.show', $article);
//    }
//
////вариант Хекслета
//public function update(Request $request, Article $article, ArticleComment $comment)
//{
//    $this->validate($request, [
//        'content' => 'required|min:10'
//    ]);
//
//    $comment->fill($request->except('_token'));
//    $comment->save();
//    return redirect()
//        ->route('articles.show', $article);
//}
//
//    public function destroy(Article $article, ArticleComment $comment)
//    {
//        $comment->delete();
//        return redirect()->route('articles.show', $article);
//    }
//}

// И ресурсный роутинг под него:
//Route::resource('/articles.comments', 'ArticleCommentController');

// И миграция:
// это функция создания самой таблицы, остальное тело класса должно быть созданно автоматически

//public function up()
//{
//    Schema::create('article_comments', function (Blueprint $table) {
//        $table->bigIncrements('id');
//        $table->string('content');
//        $table->bigInteger('article_id')->unsigned();
//        $table->foreign('article_id')->references('id')->on('articles');
//        $table->timestamps();
//    });
//}

//================================================================================КОНЕЦ
