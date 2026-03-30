<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    //ADMIN: create category
    public function createCategory($validated)
    {
        //add to db
        Category::create($validated);

        //send msg
        $title = $validated['title'];
        return "Category $title is created!";
    }

    //get articles by selected category
    public function getArticles(Category $category) {
        return $category->articles()->approved()->with('user')->latest()->paginate(5)->withQueryString();
    }
}
