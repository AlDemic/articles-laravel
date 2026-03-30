<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Article;
use App\Models\User;

class FullViewPolicy
{
    public function fullView(?User $user, Article $article) {
        return $article->status === 'approved';
    }
}
