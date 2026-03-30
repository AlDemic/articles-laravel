<?php

namespace Tests\Feature;

use Database\Seeders\RankSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

//MODELS
use App\Models\User;
use App\Models\Article;

class ApproveArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_approve_article_by_moderator(): void
    {
        $this->seed(RankSeeder::class);

        //make user
        $user = User::factory()->create([
            'rank_id' => 2
        ]);

        //make article in db
        $article = Article::factory()->create();

        $response = $this->actingAs($user)->post("/admin/api/articles/approve/{$article->id}");

        //check response
        $response->assertStatus(302)
                ->assertSessionHas('msg', 'Your positive vote is done!');

        //check record in decisions
        $this->assertDatabaseHas('decisions', [
            'article_id' => $article->id,
            'user_id' => $user->id,
            'decision_value' => $user->rank->approved_power
        ]);
    }
}
