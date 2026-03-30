<?php

namespace Tests\Feature;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\RankSeeder;

class AdminPanelForAdminOnlyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_panel_for_admin_only(): void
    {
        $this->seed(RankSeeder::class);

        //make user
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }
}
