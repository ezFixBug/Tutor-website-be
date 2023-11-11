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
            SubjectSeeder::class,
        ]);
        $this->call([
            JobSeeder::class,
        ]);
        $this->call([
            ClassSeeder::class,
        ]);
        $this->call([
            AdminSeeder::class,
        ]);
    }
}
