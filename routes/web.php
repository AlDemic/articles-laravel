<?php

use Illuminate\Support\Facades\Route;

//CONTROLLERS
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DecisionController;

//MIDDLEWARE
use App\Http\Middleware\RankNotUser;

//main
Route::get('/', [ArticleController::class, 'getAllApprovedArticles']);

//get articles by category
Route::get('/cat/{category}', [CategoryController::class, 'getCategoryArticles']);

//ARTICLES BLOCK
Route::prefix('articles')->group(function() {
    //full view of article
    Route::get('/{article}', [ArticleController::class, 'articleFullView']);

    //add new comment
    Route::post('/{article}/comments', [CommentController::class, 'addComment'])->middleware('auth');

    //search
    Route::get('/', [ArticleController::class, 'search']);
});

//COMMENTS
Route::prefix('comments')->middleware('auth')->group(function() {
    Route::delete('/{comment}', [CommentController::class, 'deleteComment']);
});


//USER BLOCK
Route::prefix('user')->group(function () {
    //GUEST
    Route::middleware('guest')->group(function() {
        //registration
        Route::get('/reg', fn() => view('user.registration'));
        Route::post('/api/reg', [UserController::class, 'registration']);

        //login
        Route::get('/login', fn() => view('user.login'));
        Route::post('/api/login', [UserController::class, 'login']);
    });

    //AUTH
    Route::middleware('auth')->group(function () {
        //logout
        Route::get('/logout', fn() => view('user.logout'));
        Route::post('/api/logout', [UserController::class, 'logout']);

        //suggest article
        Route::get('/articles/suggest', fn() => view('articles.suggest_article'));
        Route::post('/articles/suggest', [ArticleController::class, 'suggestArticle']);

        //list of own articles
        Route::get('/articles/own', [ArticleController::class, 'getOwnArticles']); 

        //promotion page
        Route::get('/promotion', [UserController::class, 'getPromotionStats']);
        Route::patch('/promotion', [UserController::class, 'getPromotion']);

        //avatar block
        Route::get('avatar', fn() => view('user.avatar')); //avatar select
        Route::patch('avatar', [UserController::class, 'changeAvatar']); //change avatar
    });
});

//ADMIN BLOCK
Route::prefix('admin')->middleware(RankNotUser::class)->group(function () {
    //GET
    Route::get('/', fn() => view('admin.index')); //main admin panel
    Route::get('/category/create', fn() => view('admin.add_category')); //add category
    Route::get('/articles/moderation', [ArticleController::class, 'moderationArticles']); //articles on moderation

    //API
    Route::prefix('api')->group(function() {
       Route::post('/category/create', [CategoryController::class, 'createCategory']); //create category

       //VOTE BLOCK
       Route::post('/articles/approve/{article}', [DecisionController::class, 'approveArticle']); //approve by administration
       Route::post('/articles/decline/{article}', [DecisionController::class, 'declineArticle']); //decline by administration
    });
});