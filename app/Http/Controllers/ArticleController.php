<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Requests\ArticleValidateRequest;

class ArticleController extends Controller
{

    /**
     * Возвращает список всех статей с учётом пейджинга. Если же сюда приходит поисковая
     * форма, то из неё ($request) извлекаются данные, и статьи извлекаются уже с определённой
     * фильтрацией - согласно запросу.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $q = $request->input('q'); // Извлекает значение по указанному ключу (если есть).

        // Like оказывает огромное влияние на производительность. Используйте их осторожно. Изучите индексы
        // и полнотекстовый поиск.
        // Если $q - true (т.е НЕ пустое), то присв-ется 1ое значение, а еси false (null/пустое) то 2ое.
        // В 1ом значении про-ит фильтрация по слову, встречающемуся в названии статьи с учётом пагинации.
        // q передаётся 2ым пар-ом, чтобы строка поиска не оставалась пустой после выполнения.
        $articles = $q ? Article::where('name', 'like', "%{$q}%")->paginate(3) : Article::paginate(3);
        return view('article.index', compact('articles', 'q'));
    }

    /**
     * Вывод формы.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // Передаем в шаблон вновь созданный объект. Он нужен для вывода формы через Form::model
        $article = new Article();
//        dd($article);
        return view('article.create', compact('article'));
    }

    /**
     * Обработчик формы создания статьи. Сначала проверяются данные формы с применением Form Request
     * (ArticleValidateRequest) и если форма не пройдет проверку, то этот метод даже не начнёт исполняться,
     * а если всё хорошо, то создаётся ноый об.класса статья, в него записываются данные из формы
     * и он сохраняется в БД. Form Request позволяет избежать дублирования кода за счёт того, что берёт
     * валидациюна себя, позволяя удалить её из методов контроллера.
     * Здесь нам понадобится объект запроса, для извлечения данных.
     * @param ArticleValidateRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     * @param $id  определенный в маршруте, приходит в обработчик как аргумент.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // Специальная ф., которая в случае отсутсвия искомого элемента
        // вернёт обработанное исключение, в отличие от ф.find.
        $article = Article::findOrFail($id);
        return view('article.show', compact('article'));
    }

    /**
     * @param $id определенный в маршруте, приходит в обработчик как аргумент.
     * Мы не создаем сущность с нуля, для передачи в форму, как при создании
     * новой статьи, а извлекаем ее из базы.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('article.edit', compact('article'));
    }

    /**
     * @param Request $request - из него извлекаются данные формы.
     * @param $id определенный в маршруте, приходит в обработчик как аргумент.
     * Обработчик, который проверит данные формы и сохранит обновления, сделая редирект
     * на маршрут списка статей, или выдаст ошибку. Сначала находиться конкретная запись в БД по id,
     * затем происходит валидация данных из пришедшей формы с исключением найденной записи. А потом
     * найденная запись просто перезавписывается.
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
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
     * Не забывайте про авторизацию -Удаление должно быть
     * доступно только тем, кто может его выполнять.
     * @param $id для поиска сущности
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // DELETE идемпотентный метод, поэтому результат операции всегда один и тот же
        $article = Article::find($id);
//        dd($article->name);
        $name = $article->name;
        if ($article) {
            $article->delete();
        }

        \Session::flash('flash_message', 'Милорд, статья: ' . $name . ' удалена успешно!');
        return redirect()->route('articles.index');
    }

}
