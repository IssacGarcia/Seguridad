<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::create([
            'name' => 'Test User1',
            'email' => 'issacgar98@gmail.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::create([
            'name' => 'Test User2',
            'email' => 'issacgar2@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
