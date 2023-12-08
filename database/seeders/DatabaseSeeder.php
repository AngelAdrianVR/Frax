<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Frax::create([
            'name' => 'Real Cantabria',
            'address' => 'Prolongación 16 de septiembre 3700',
            'is_active' => '1',
            'phone' => '3312154545',
            'admin_name' => 'Hugo Mtz',
            'number_houses' => '638',
            'email' => 'cantabria@gmail.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Angel VR',
            'email' => 'angel@gmail.com',
            'frax_id' => '1',
            'password' => bcrypt('321321321'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Miguel VR',
            'email' => 'miguel@t.com',
            'frax_id' => '1',
            'password' => bcrypt('321321321'),
        ]);
    }
}
