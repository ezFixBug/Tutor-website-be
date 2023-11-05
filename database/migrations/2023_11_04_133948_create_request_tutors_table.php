<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_tutors', function (Blueprint $table) {
            $table->primary('id');
            $table->uuid('id')->comment('ID');
            $table->uuid('user_id')->nullable(false);
            $table->string('title')->nullable(false);
            $table->integer('subject_id')->nullable(false);
            $table->integer('class_id')->nullable(false);
            $table->integer('course_type_cd')->nullable(false);
            $table->integer('num_day_per_week')->nullable(false);
            $table->integer('num_hour_per_day')->nullable(false);
            $table->integer('num_student')->nullable(false);
            $table->integer('price')->nullable(false);
            $table->integer('sex')->nullable(false);
            $table->longText('description')->nullable(false);
            $table->jsonb('schedule')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_tutors');
    }
}
