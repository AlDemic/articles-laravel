<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rank::insert([
            ['id' => 1, 'title' => 'Simple User', 'approved_power' => 0],
            ['id' => 2, 'title' => 'Moderator', 'approved_power' => 3],
            ['id' => 3, 'title' => 'Administrator', 'approved_power' => 5]
        ]);
    }
}
