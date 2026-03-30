<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\RankSeeder;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_by_user(): void
    {
        $this->seed(RankSeeder::class);

        //create user
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/user/api/logout');

        //check answer
        $response->assertRedirect('/')
                    ->assertSessionHas('msg', 'Successfully logout!');

        //check if guest
        $this->assertGuest();
    }
}