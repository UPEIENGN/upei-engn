<?php

namespace Database\Seeders;

use App\Models\Society;
use App\Models\User;
use App\SocietyMemberRole;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $society = Society::factory()->create();

        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'engnsociety@upei.ca',
            'password' => '$2y$12$3PNTSzNDgwZZobvdgd8wOO1c36ZkkecD6WL1MUSXZ5qnRvlWWflK6',
        ]);

        $society->members()->create([
            'name' => $user->name,
            'email' => $user->email,
            'role' => SocietyMemberRole::Owner,
            'renewed_at' => now(),
        ]);
    }
}
