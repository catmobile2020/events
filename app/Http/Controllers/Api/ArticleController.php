<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Resources\ArticleResource;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     *
     * @SWG\Get(
     *      tags={"articles"},
     *      path="/articles",
     *      summary="Get articles",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Response(response=200, description="object"),
     * )
     */
    public function index()
    {
        $articles = Article::where('active',1)->latest()->paginate(5);
        return ArticleResource::collection($articles);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"articles"},
     *      path="/articles/{article}",
     *      summary="Get Single article",
     *      security={
     *          {"jwt": {}}
     *      },
     *     @SWG\Parameter(
     *         name="article",
     *         in="path",
     *         required=true,
     *         type="integer",
     *         format="integer",
     *      ),
     *      @SWG\Response(response=200, description="object"),
     * )
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Article $article)
    {
        if ($article->active)
            return ArticleResource::make($article);
        return response()->json(['data'=>'Article is Not Active Yet !'],402);
    }
}
