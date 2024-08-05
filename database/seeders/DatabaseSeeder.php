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
        $this->call([
            StudentSeeder::class
        ]);

        // \App\Models\User::factory(12000)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Manikandan Developer',
        //     'email' => 'gmanikandan845@gmail.com',
        // ]);
    }
}
