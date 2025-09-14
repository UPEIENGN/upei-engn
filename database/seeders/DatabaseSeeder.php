<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Society;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\SocietyMemberRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->isAdmin()->create([
            'name' => 'Test User',
            'email' => 'a@b.c',
        ]);

        $society = Society::factory()->create([
            'name' => 'Test Society',
        ]);

        $society->members()->create([
            'email' => $user->email,
            'role' => SocietyMemberRole::Owner,
        ]);

        Event::factory(20)->society($society)->create();
    }
}
