<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;

//MODELS
use App\Models\Article;

class ArticleService
{
    //take all approved articles(for main page -> category: All)
    public function getAllApprovedArticles() {
        return Article::approved()->with(['user', 'category'])->latest()->paginate(5);
    }

    //add to db suggested article from user
    public function suggestArticle($validated) {
        $user = Auth::user();

        //add to db by relation
        $user->articles()->create($validated);

        //user inform
        return 'Article is added! Wait for moderation';
    }

    //take all articles on moderation by filter
    public function moderationArticles($filter) {
        switch($filter) {
            case 'canMod':
                $articles = Article::onModeration()->userNotAuthor()->userCanVote();
                break;
            case 'doneMod':
                $articles = Article::onModeration()->userNotAuthor()->userCantVote();
                break;
            case 'declined':
                $articles = Article::declined();
                break;
            default: 
                $articles = Article::onModeration();
        }

        return $articles->with(['user'])->isUserCanVote()->votesBlock()->latest()->paginate(5)->withQueryString();
    }

    //take user's articles by filter
    public function getOwnArticles($filter) {
        switch($filter) {
            case 'approved':
                $articles = Article::approved();
                break;
            case 'onMod':
                $articles = Article::onModeration();
                break;
            case 'declined':
                $articles = Article::declined();
                break;
            default:
                $articles = Article::query();
        }

        return $articles->userAuthor()->with('user')->latest()->paginate(5)->withQueryString();
    }

    //article full view
    public function articleFullView(Article $article) {
        return $article->comments()->with('user')->latest()->paginate(3);
    }

    //search logic
    public function search($line) {
        if($line) {
            $articles = Article::search($line)
                                ->approved()
                                ->paginate(5)
                                ->withQueryString();
            return $articles;
        }

        return false;
    }
}
