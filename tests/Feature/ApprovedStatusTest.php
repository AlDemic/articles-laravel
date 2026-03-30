<?php

namespace Tests\Feature;

use Database\Seeders\RankSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

//MODELS
use App\Models\Article;
use App\Models\User;

class ApprovedStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_approved_status_article(): void
    {
        $this->seed(RankSeeder::class);

        //create article
        $article = Article::factory()->create();

        //create 2 admins
        for($i = 1; $i <= 2; $i++) {
            $user[$i] = User::factory()->create([
                'rank_id' => 3
            ]);
        }

        //make approved
        foreach($user as $u) {
            $this->actingAs($u)->post("/admin/api/articles/approve/{$article->id}");
        }

        //check status (should be approved)
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => 'approved'
        ]);
    }
}
