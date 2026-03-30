<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Services\CommentService;
use App\Models\Article;
use App\Models\Comment;

use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function addComment(Article $article, AddCommentRequest $request, CommentService $service) {
        //check user form
        $validated = $request->validated();

        //logic
        $result = $service->addComment($article, $validated);

        //inform user
        return back()->with('msg', $result);
    }

    public function deleteComment(Comment $comment, CommentService $service) {
        if(! Gate::allows('delete-comment')) {
            abort(403);
        }
        
        //logic
        $result = $service->deleteComment($comment);

        return back()->with('msg', $result);
    }
}
