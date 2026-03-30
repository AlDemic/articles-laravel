<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\RankSeeder;

//MODELS
use App\Models\User;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_category(): void
    {
        $this->seed(RankSeeder::class);

        //create user as admin
        $user = User::factory()->create([
            'rank_id' => 3
        ]);

        $category = [
            'title' => 'Test',
            'url' => 'test'
        ];

        //request
        $response = $this->actingAs($user)->post('/admin/api/category/create', $category);

        //check answer
        $response->assertStatus(302)
                    ->assertSessionHas('msg', "Category Test is created!");

        //check db            
        $this->assertDatabaseHas('categories', $category);
    }
}
