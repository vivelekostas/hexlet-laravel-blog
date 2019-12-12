<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * массив, в котором перечисляются поля, доступные для mass-assignment.
     * Все что там не перечислено будет игнорироваться.
     * @var array
     */
    protected $fillable = ['name', 'body'];

    /**
     * Отношение «один ко многим» - здесь это статья в блоге, которая имеет «много» комментариев.
     * Этот метод, как бы, позволяет передавать в шаблон все коментарии относящиеся к этой статье.
     * Короче: позволяет получить комментарии статьи блога.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(__NAMESPACE__ . '\ArticleComment');
    }
}
