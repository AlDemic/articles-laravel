<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//MODELS 
use App\Models\Article;

//SERVICES
use App\Services\DecisionService;

class DecisionController extends Controller
{
    //approve article
    public function approveArticle(Article $article, DecisionService $service) {
        //action logic
        $result = $service->voteArticle($article, 'positive');

        return back()->with('msg', $result);
    }

    //decline article
    public function declineArticle(Article $article, DecisionService $service) {
        //action logic
        $result = $service->voteArticle($article, 'negative');

        return back()->with('msg', $result);
    }
}
