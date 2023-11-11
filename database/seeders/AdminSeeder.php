<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminUser::query()->truncate();
        AdminUser::create([
            'id' => 1,
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '$2a$12$uWhCnd4.yxfGAx5wu6ikGOIxXwyIevaXWSDSmEJS93aq9AgvqQWPW' // password
        ]);
    }
}
