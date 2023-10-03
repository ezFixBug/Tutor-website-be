<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::query()->truncate();
        Job::create([
            'id' => 1,
            'name' => 'Học sinh',
        ]);
        Job::create([
            'id' => 2,
            'name' => 'Sinh viên',
        ]);
        Job::create([
            'id' => 3,
            'name' => 'Giáo viên',
        ]);
        Job::create([
            'id' => 4,
            'name' => 'Giảng viên đại học',
        ]);
        Job::create([
            'id' => 5,
            'name' => 'Giáo sư',
        ]);
        Job::create([
            'id' => 6,
            'name' => 'Tiến sĩ',
        ]);
        Job::create([
            'id' => 7,
            'name' => 'Chuyên gia',
        ]);
        Job::create([
            'id' => 8,
            'name' => 'Khác',
        ]);

    }
}
