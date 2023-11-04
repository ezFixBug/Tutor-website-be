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
            'image' => 'https://media.dolenglish.vn/PUBLIC/MEDIA/15114359-77ed-45bf-a9f9-3b0f018d3e00.jpg'
        ]);
        Subject::create([
            'id' => 2,
            'name' => 'Tiếng Việt/Ngữ văn',
            'image'=> 'https://ischool.vn/wp-content/uploads/2023/01/cach-hoc-ngu-van-hieu-qua-1.jpg'
        ]);
        Subject::create([
            'id' => 3,
            'name' => 'Tiếng Anh',
            'image' => 'https://cdn.sforum.vn/sforum/wp-content/uploads/2022/11/ung-dung-hoc-tieng-anh-0.jpg'
        ]);
        Subject::create([
            'id' => 4,
            'name' => 'Vật lý',
            'image' => 'https://monkeymedia.vcdn.com.vn/upload/web/storage_web/24-05-2022_17:22:59_cac-cong-thuc-vat-ly-7.jpg'
        ]);
        Subject::create([
            'id' => 5,
            'name' => 'Hóa học',
            'image'=> 'https://tudienhoahoc.com/wp-content/uploads/2019/10/hoa-hoc-la-gi.jpg'
        ]);
        Subject::create([
            'id' => 6,
            'name' => 'Sinh học',
            'image'=> 'https://aztest.vn/uploads/news/2019/1_12.jpg'
        ]);
        Subject::create([
            'id' => 7,
            'name' => 'Xác xuất thống kê',
            'image'=> 'https://media.dolenglish.vn/PUBLIC/MEDIA/b6260e9c-be5b-416d-9c64-3dc76ec21386.jpg'
        ]);
        Subject::create([
            'id' => 8,
            'name' => 'Lập trình website',
            'image'=> 'https://vtiacademy.edu.vn/upload/images/lap-trinh-web.jpg'
        ]);
        Subject::create([
            'id' => 9,
            'name' => 'Lập trình mobile',
            'image'=> 'https://plus.vtc.edu.vn/wp-content/uploads/2022/08/mobile-developer-la-gi.png'
        ]);
        Subject::create([
            'id' => 10,
            'name' => 'Kỹ năng mềm',
            'image'=> 'https://images.careerbuilder.vn/content/images/loi-ich-tu-nhung-ky-nang-mem-careerbuilder.jpg'
        ]);
        Subject::create([
            'id' => 11,
            'name' => 'Kinh tế vi mô',
            'image'=> 'https://vncsi.com.vn/data/data/anhpnh/2021/04/07/kinh-te-vi-mo.jpg'
        ]);
        Subject::create([
            'id' => 12,
            'name' => 'Kinh tế vĩ mô',
            'image'=> 'https://lmstvu.onschool.edu.vn/pluginfile.php/264771/course/overviewfiles/Kinh%20t%E1%BA%BF%20v%C4%A9%20m%C3%B4.jpg'
        ]);
        Subject::create([
            'id' => 13,
            'name' => 'Data analysis',
            'image'=> 'https://res.cloudinary.com/hevo/image/upload/f_auto,q_auto/v1685908430/hevo-learn-1/dataanalysisistockrobuart.jpg?_i=AA'
        ]);
        Subject::create([
            'id' => 14,
            'name' => 'Khoa học dữ liệu',
            'image'=> 'https://fita.vnua.edu.vn/wp-content/uploads/2021/04/luong-nganh-tri-tue-nhan-tao-len-den-510-trieu-dong-2-500x466.jpg'
        ]);
        Subject::create([
            'id' => 15,
            'name' => 'SEO',
            'image'=> 'https://dewahoster.co.id/blog/wp-content/uploads/2020/08/SEO.jpg'
        ]);
        Subject::create([
            'id' => 16,
            'name' => 'Tiếng Trung',
            'image'=> 'https://png.pngtree.com/templates/20190520/ourlarge/pngtree-chinese-literature-society-recruitment-poster-speechchinese-language-and-image_200974.jpg'
        ]);
        Subject::create([
            'id' => 17,
            'name' => 'Tiếng Nhật',
            'image'=> 'https://citc.edu.vn/wp-content/uploads/2020/03/dai-hoc-nganh-ngon-ngu-nhat.jpg'
        ]);
        Subject::create([
            'id' => 18,
            'name' => 'IELTS',
            'image'=> 'https://res.edu.vn/wp-content/uploads/2021/11/luyen-thi-ielts-danh-cho-nguoi-moi-dat-dau.png'
        ]);
        Subject::create([
            'id' => 19,
            'name' => 'TOEIC',
            'image'=> 'https://speakingeasily.com/wp-content/uploads/2020/02/toeic-500x333.png'
        ]);
        Subject::create([
            'id' => 20,
            'name' => 'Thiết kế đồ họa',
            'image'=> 'https://cms.rightpath.edu.vn/uploads/TKDH_1_B_f91ea252d2.jpg'
        ]);
        Subject::create([
            'id' => 21,
            'name' => 'Âm nhạc',
            'image'=> 'https://storage.googleapis.com/youth-media/post-thumbnails/tBkZ8K4VF5PxohVoC7u0tDz9UeT8z8msVilEnVgR.jpg'
        ]);
    }
}