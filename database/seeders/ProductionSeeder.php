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
        $user = new User;
        $user->name = 'admin';
        $user->email = 'engnsociety@upei.ca';
        $user->password = '$2y$12$3PNTSzNDgwZZobvdgd8wOO1c36ZkkecD6WL1MUSXZ5qnRvlWWflK6';
        $user->save();

        $society = new Society;
        $society->name = 'UPEI Engineering';
        $society->email = $user->email;
        $society->save();

        $society->members()->create([
            'name' => $user->name,
            'email' => $user->email,
            'role' => SocietyMemberRole::Owner,
            'renewed_at' => now(),
        ]);
    }
}
