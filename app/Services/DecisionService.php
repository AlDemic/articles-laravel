<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

//MODELS
use App\Models\Article;
use App\Models\Decision;

class DecisionService
{
    //common block for create
    private function createDecisionArray(Article $article, $typeDecision) {
        $approvedPower = $typeDecision === 'positive'
                                                ? Auth::user()->approvedPower()
                                                : -(Auth::user()->approvedPower());
        return [
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'decision_value' => $approvedPower
        ];
    }

    //common block for vote
    public function voteArticle(Article $article, $typeDecision) {
        //make array for db creation
        $decisionArray = $this->createDecisionArray($article, $typeDecision);

        Decision::create($decisionArray);

        //check status
        $article->checkStatus();

        //inform user
        return "Your $typeDecision vote is done!";
    }
}
