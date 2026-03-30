<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

//SERVICES
use App\Services\CategoryService;

//REQUESTS
use App\Http\Requests\CreateCategoryRequest;

class CategoryController extends BaseController
{
    //create category
    public function createCategory(CreateCategoryRequest $request, CategoryService $service) {
        //validation of form
        $validated = $request->validated();

        //logic
        $result = $service->createCategory($validated);

        //answer
        return back()->with('msg', $result);
    }

    //get list of articles by category
    public function getCategoryArticles(Category $category, CategoryService $service) {
        //get articles
        $articles = $service->getArticles($category);

        //view
        return view('articles.cat_articles', ['articles' => $articles]);
    }
}
