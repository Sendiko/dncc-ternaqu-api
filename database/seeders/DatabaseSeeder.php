<?php

namespace Database\Seeders;

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
        $this->call([
            UserSeeder::class,
            RecipeSeeder::class,
            ProductSeeder::class,
            StoreSeeder::class,
            TopicSeeder::class
        ]);
    }
}
