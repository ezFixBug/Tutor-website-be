<?php

namespace Database\Seeders;

use App\Models\UserClass;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserClass::query()->truncate();
        for($i = 1; $i <= 12; $i++) {
            UserClass::create([
                'id' => $i,
                'name' => 'Lớp '.$i
            ]);
        }

        UserClass::create([
            'id' => 13,
            'name' => 'Đại học'
        ]);
        UserClass::create([
            'id' => 14,
            'name' => 'Ôn thi Đại học'
        ]);
        UserClass::create([
            'id' => 15,
            'name' => 'Giao tiếp'
        ]);
        UserClass::create([
            'id' => 16,
            'name' => 'Các lớp khác'
        ]);
    }
}
