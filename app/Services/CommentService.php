<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;

//MODELS
use App\Models\Article;
use App\Models\Comment;

class CommentService
{
    //add new comment
    public function addComment(Article $article, $validated) {
        //add to db
        $article->comments()->create([
            ...$validated,
            'user_id' => Auth::id()
            ]);

        return 'Comment is added!';
    }

    //delete comment
    public function deleteComment(Comment $comment) {
        $comment->delete();

        return 'Deleted!';
    }
}
