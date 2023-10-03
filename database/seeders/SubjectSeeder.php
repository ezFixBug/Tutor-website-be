<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::query()->truncate();
        Subject::create([
            'id' => 1,
            'name' => 'Toán',
        ]);
        Subject::create([
            'id' => 2,
            'name' => 'Tiếng Việt/Ngữ văn',
        ]);
        Subject::create([
            'id' => 3,
            'name' => 'Tiếng Anh',
        ]);
        Subject::create([
            'id' => 4,
            'name' => 'Vật lý',
        ]);
        Subject::create([
            'id' => 5,
            'name' => 'Hóa học',
        ]);
        Subject::create([
            'id' => 6,
            'name' => 'Sinh học',
        ]);
        Subject::create([
            'id' => 7,
            'name' => 'Xác xuất thống kê',
        ]);
        Subject::create([
            'id' => 8,
            'name' => 'Lập trình website',
        ]);
        Subject::create([
            'id' => 9,
            'name' => 'Lập trình mobile',
        ]);
        Subject::create([
            'id' => 10,
            'name' => 'Kỹ năng mềm',
        ]);
        Subject::create([
            'id' => 11,
            'name' => 'Kinh tế vi mô',
        ]);
        Subject::create([
            'id' => 12,
            'name' => 'Kinh tế vĩ mô',
        ]);
        Subject::create([
            'id' => 13,
            'name' => 'Data analysis',
        ]);
        Subject::create([
            'id' => 14,
            'name' => 'Khoa học dữ liệu',
        ]);
        Subject::create([
            'id' => 15,
            'name' => 'SEO',
        ]);
        Subject::create([
            'id' => 16,
            'name' => 'Tiếng Trung',
        ]);
        Subject::create([
            'id' => 17,
            'name' => 'Tiếng Nhật',
        ]);
        Subject::create([
            'id' => 18,
            'name' => 'IELTS',
        ]);
        Subject::create([
            'id' => 19,
            'name' => 'TOEIC',
        ]);
        Subject::create([
            'id' => 20,
            'name' => 'Thiết kế đồ họa',
        ]);
    }
}