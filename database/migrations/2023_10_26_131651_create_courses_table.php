<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->primary('id');
            $table->uuid('id')->comment('ID');
            $table->uuid('user_id')->nullable(false);
            $table->string('image')->nullable(false);
            $table->string('title')->nullable(false);
            $table->string('sub_title')->nullable(false);
            $table->string('price')->unique()->nullable(true);
            $table->string('description')->nullable(false);
            $table->longText('content')->nullable(false);
            $table->integer('type_cd')->default(Constants::CD_TYPE_OFFLINE);
            $table->date('start_date')->nullable(true);
            $table->time('time_start')->nullable(true);
            $table->integer('province_id')->nullable(true);
            $table->integer('district_id')->nullable(true);
            $table->string('street')->nullable(true);
            $table->string('link')->nullable(true);
            $table->jsonb('schedule')->nullable(true);
            $table->jsonb('tags')->nullable(true);
            $table->integer('status_cd')->nullable(false)->defaultValue(Constants::CD_WAITING_TO_ACCEPT);
            $table->rememberToken();
            $table->timestamps();
            $table->timestampTz('deleted_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
