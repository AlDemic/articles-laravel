<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'short_desc' => $this->faker->sentence(100),
            'full_desc' => $this->faker->sentence(255),
            'category_id' => Category::factory(),
            'status' => 'moderation',
            'user_id' => User::factory()
        ];
    }
}
