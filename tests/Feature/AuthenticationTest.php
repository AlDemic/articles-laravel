<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\RankSeeder;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_authentication(): void
    {
        $this->seed(RankSeeder::class);

        $password = '12345678a';

        //generate user in db
        $user = User::factory()->create([
            'password' => bcrypt($password)
        ]);

        //login
        $response = $this->actingAsGuest()->post('/user/api/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        //check answer
        $response->assertRedirect('/')
                    ->assertSessionHas('msg', 'Successfully!');
        
        //check if authenticated
        $this->assertAuthenticated();
    }
}
