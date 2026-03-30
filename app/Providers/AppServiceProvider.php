<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;

use App\Models\Category;
use App\Models\Article;
use App\Policies\FullViewPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layout', 'articles.suggest_article'], function($view) {
            $categories = Category::all();
            return $view->with('categories', $categories);
        });

        Gate::define('delete-comment', function($user) {
            return $user->rank_id > 2; //only for moderator
        });

        //POLICIES
        Gate::policy(Article::class, FullViewPolicy::class);
    }
}
