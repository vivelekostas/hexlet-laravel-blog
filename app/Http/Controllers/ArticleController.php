<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleComment;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleValidateRequest;

/**
 * Класс отвечающий за CRUD статьи. Это новый. Старый хоть и носил такое же название, но наполнялся обработчиками
 * мною постепенно и собственноручно. Новый создался уже с каркасом из всех необходимых методов, осталась их напо-
 * лнить содержанием. Ещё он часто в параметры методов принимает саму сущность из БД, а не id, как было раньше.
 * Это позволяет сократить код не много.
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * Возвращает список всех статей с учётом пейджинга. Если же сюда приходит поисковая
     * форма, то из неё ($request) извлекаются данные, и статьи извлекаются уже с определённой
     * фильтрацией - согласно запросу.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->input('q'); // Извлекает значение по указанному ключу (если есть).

        // Like оказывает огромное влияние на производительность. Используйте их осторожно. Изучите индексы
        // и полнотекстовый поиск.
        // Если $q - true (т.е НЕ пустое), то присв-ется 1ое значение, а еси false (null/пустое) то 2ое.
        // Во 1ом значении про-ит фильтрация по слову, встречающемуся в названии статьи с учётом пагинации.
        // Во 20м значении про-ит вывод всех статей по дате создания, начиная с новых.
        // q передаётся 2ым пар-ом, чтобы строка поиска не оставалась пустой после выполнения.
        $articles = $q ? Article::where('name', 'like', "%{$q}%")->paginate(3) : Article::orderBy('created_at', 'desc')->paginate(3);
        return view('article.index', compact('articles', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = new Article();
//        dd($article);
        return view('article.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     * Обработчик формы создания статьи. Сначала проверяются данные формы с применением Form Request
     * (ArticleValidateRequest) и если форма не пройдет проверку, то этот метод даже не начнёт исполняться,
     * а если всё хорошо, то создаётся ноый об.класса статья, в него записываются данные из формы
     * и он сохраняется в БД. Form Request позволяет избежать дублирования кода за счёт того, что берёт
     * валидациюна себя, позволяя удалить её из методов контроллера.
     * Здесь нам понадобится объект запроса, для извлечения данных.
     * @param ArticleValidateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleValidateRequest $request)
    {
        // validate - тут работает ArticleValidateRequest, точнее он ещё раньше срабатывает)

        $article = new Article();
        // Заполнение статьи данными из формы. Метод all() возвращает все данные формы,
        // а метод fill($params) выполняет установку сразу всех значений через передачу
        // ассоциативного массива.
        $article->fill($request->all());
        // При ошибках сохранения возникнет исключение
        $article->save();

        // Редирект на указанный маршрут с добавлением флеш сообщения
        \Session::flash('flash_message', 'Новая статья успешно создана, милорд!');
        return redirect()
            ->route('articles.index');
    }

    /**
     * Display the specified resource.
     * И передаёт пустой коммент для формы
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $newComment = new ArticleComment();
        return view('article.show', compact('article', 'newComment'));
    }

    /**
     * Show the form for editing the specified resource.
     * Мы не создаем сущность с нуля, для передачи в форму, как при создании
     * новой статьи, а извлекаем ее из базы.
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Article $article
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Article $article)
    {
        $this->validate($request, [
            // тут пока без ArticleValidateRequest)
            // У обновления немного измененная валидация. В проверку уникальности добавляется
            // название поля и id текущего объекта.
            // Если этого не сделать, Laravel будет ругаться на то что имя уже существует
            'name' => 'required|unique:articles,name,' . $article->id,
            'body' => 'required|min:10',
        ]);

        $article->fill($request->all());
        $article->save();
        \Session::flash('flash_message', 'Милорд, эта статья успешно обновлена!');
        return redirect()
            ->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     * Не забывайте про авторизацию -Удаление должно быть
     * доступно только тем, кто может его выполнять.
     * @param \App\Article $article
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        // DELETE идемпотентный метод, поэтому результат операции всегда один и тот же

        $name = $article->name;
        if ($article) {
            $article->delete();
        }

        \Session::flash('flash_message', 'Милорд, статья: ' . $name . ' удалена успешно!');
        return redirect()->route('articles.index');
    }
}
