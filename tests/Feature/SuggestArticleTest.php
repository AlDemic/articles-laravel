<?php

namespace Tests\Feature;

use Database\Seeders\RankSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

//MODELS
use App\Models\User;
use App\Models\Category;

class SuggestArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_suggest_article(): void
    {
        $this->seed(RankSeeder::class);

        $user = User::factory()->create();

        $category = Category::factory()->create();

        $article = [
            'title' => 'Test1',
            'category_id' => $category->id,
            'full_desc' => 'Some test for suggest article status!Some test for suggest article status!Some test for suggest article status!
            Some test for suggest article status!Some test for suggest article status!Some test for suggest article status!
            Some test for suggest article status!'
        ];

        //make request
        $response = $this->actingAs($user)->post('/user/articles/suggest', $article);

        //check answer
        $response->assertStatus(302)
                ->assertSessionHas('msg', 'Article is added! Wait for moderation');

        //check that has in db
        $this->assertDatabaseHas('articles', [
            'title' => $article['title'],
            'short_desc' => substr($article['full_desc'], 0, 255),
            'full_desc' => $article['full_desc'],
            'category_id' => $category->id,
            'status' => 'moderation',
            'user_id' => $user->id
        ]);
    }
}
