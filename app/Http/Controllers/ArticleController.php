<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Policies\FullViewPolicy;

//MODELS
use App\Models\Article;

//REQUESTS
use App\Http\Requests\SuggestArticleRequest;

//SERVICES
use App\Services\ArticleService;

class ArticleController extends BaseController
{
    //suggested article from user
    public function suggestArticle(SuggestArticleRequest $request, ArticleService $service) {
        //check user's form
        $validated = $request->validated();

        //logic
        $result = $service->suggestArticle($validated);

        //answer
        return back()->with('msg', $result);
    }

    //get list of all approved articles
    public function getAllApprovedArticles(ArticleService $service) {
        //logic
        $articles = $service->getAllApprovedArticles();

        return view('index', ['articles' => $articles]);
    }

    //list of articles by filter for moderation
    public function moderationArticles(Request $request, ArticleService $service) {
        //get filter from request
        $filter = $request->filter;

        //get articles by filter
        $articles = $service->moderationArticles($filter);

        return view('admin.moderation', ['articles' => $articles, 'filter' => $filter]);
    }

    //list of user's articles with status
    public function getOwnArticles(Request $request, ArticleService $service) {
        //get filter
        $filter = $request->filter ?? '';

        //take articles by filter
        $articles = $service->getOwnArticles($filter);

        return view('user.own_articles', ['articles' => $articles, 'filter' => $filter]);
    }

    //article full view
    public function articleFullView(Article $article, ArticleService $service) {
        //check if approved status
        $this->authorize('fullView', $article);

        //logic: take article details + comments
        $comments = $service->articleFullView($article);

        return view('articles.full_view', ['article' => $article, 'comments' => $comments]);
    }

    //search articles
    public function search(Request $request, ArticleService $service) {
        $searchLine = $request->search;

        //logic
        $articles = $service->search($searchLine);

        return view('search', ['articles' => $articles]);
    }
}
