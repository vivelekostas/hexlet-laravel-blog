<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    /**
     * массив, в котором перечисляются поля, доступные для mass-assignment.
     * Все что там не перечислено будет игнорироваться.
     * @var array
     */
    protected $fillable = ['content'];

    /**
     * Один ко многим (Обратное отношение) После получения доступа ко всем комментариям
     * статьи давай определим отношение, которое позволит комментарию получить доступ к
     * его статье. Короче: позволяет получить статью данного комментария.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(__NAMESPACE__ . '\Article');
    }
}
