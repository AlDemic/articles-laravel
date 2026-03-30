<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\RankSeeder;
//PIC 
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ChangeAvatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_avatar(): void
    {
        $this->seed(RankSeeder::class);

        //file upload
        Storage::fake('public');
        $avatar = UploadedFile::fake()->image('user-avatar.png');
        
        //create user
        $user = User::factory()->create();

        //request
        $response = $this->actingAs($user)->patch('/user/avatar', [
            'avatar' => $avatar
        ]);

        //check answer
        $response->assertRedirectBack()
                    ->assertSessionHas('msg', 'Your avatar is changed!');
        
        //check db
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'avatar' => "avatars/" . $avatar->hashName()
        ]);

        //check storage
        Storage::disk('public')->assertExists('avatars/'. $avatar->hashName());
    }
}
