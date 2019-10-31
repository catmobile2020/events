<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Helpers\UploadImage;
use App\Http\Requests\Admin\ArticleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    use UploadImage;

    public function index(Request $request)
    {
        $rows = Article::latest()->paginate(20);
        return view('admin.pages.article.index',compact('rows'));
    }

    public function create()
    {
        $article = new Article;
        return view('admin.pages.article.form',compact('article'));
    }


    public function store(ArticleRequest $request)
    {
        $inputs = $request->except('photo');
        $article = Article::create($inputs);
        $this->upload($request->photo,$article);
        return redirect()->route('admin.articles.index')->with('message','Done Successfully');
    }


    public function show($id)
    {

    }


    public function edit(Article $article)
    {
        return view('admin.pages.article.form',compact('article'));
    }


    public function update(ArticleRequest $request, Article $article)
    {
        $inputs = $request->except('photo');
        $article->update($inputs);
        if ($request->photo)
            $this->upload($request->photo,$article,null,true);
        return redirect()->route('admin.articles.index')->with('message','Done Successfully');
    }


    public function destroy(Article $article)
    {
        $article->trash();
        return redirect()->route('admin.articles.index')->with('message','Done Successfully');
    }
}
