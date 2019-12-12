<?php

namespace App\Http\Controllers;

use App\ArticleComment;
use App\Article;
use Illuminate\Http\Request;

class ArticleCommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Article $article
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Article $article)
    {
        $this->validate($request, [
            'content' => 'required|min:10'
        ]);

        // Это мой вариант
        // $comment = new articleComment();
        // $comment->content = $request->input('content');
        // $comment->article_id = $article->id;

        // Это с хекслета - более "магический". Видимо создаётся
        // новый коммент и сразу присваиваевается ему article_id.
        $comment = $article->comments()->make();
        $comment->fill($request->except('_token'));
        $comment->save();
        return redirect()->route('articles.show', $article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Article $article
     * @param ArticleComment $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article, ArticleComment $comment)
    {
        return view('article_comment.edit', compact('article', 'comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Article $article
     * @param ArticleComment $comment
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Article $article, ArticleComment $comment)
    {
        $this->validate($request, [
            'content' => 'required|min:10'
        ]);

        $comment->fill($request->except('_token'));
        $comment->save();
        return redirect()
            ->route('articles.show', $article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Article $article
     * @param ArticleComment $comment
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Article $article, ArticleComment $comment)
    {
        $comment->delete();
        return redirect()->route('articles.show', $article);
    }
}
