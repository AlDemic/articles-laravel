<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\RankSeeder;
use Tests\TestCase;

//MODELS
use App\Models\User;
use App\Models\Article;

class DeclineArticleByAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_decline_article_by_administrator(): void
    {
        $this->seed(RankSeeder::class);

        //make user
        $user = User::factory()->create([
            'rank_id' => 3
        ]);

        //make article in db
        $article = Article::factory()->create();

        $response = $this->actingAs($user)->post("/admin/api/articles/decline/{$article->id}");

        //check response
        $response->assertStatus(302)
                ->assertSessionHas('msg', 'Your negative vote is done!');

        //check record in decisions
        $this->assertDatabaseHas('decisions', [
            'article_id' => $article->id,
            'user_id' => $user->id,
            'decision_value' => -($user->rank->approved_power)
        ]);
    }
}