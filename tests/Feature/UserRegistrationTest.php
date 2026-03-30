<?php

namespace Tests\Feature;

use Database\Seeders\RankSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration(): void
    {
        $this->seed(RankSeeder::class);

        $user = [
            'nick' => 'Test',
            'email' => 'test@email.com',
            'password' => '12345678',
        ];

        $response = $this->actingAsGuest()->post('/user/api/reg', $user);

        //check answer
        $response->assertRedirect('/user/reg')
                ->assertSessionHas('msg', 'Registration is successfully');

        //check db
        $this->assertDatabaseHas('users', [
            'nick' => $user['nick'],
            'email' => $user['email']
        ]);
    }
}
