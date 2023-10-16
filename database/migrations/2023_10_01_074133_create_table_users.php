<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->primary('id');
            $table->uuid('id')->comment('ID');
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('avatar')->nullable(false);
            $table->string('email')->unique()->nullable(false);
            $table->string('phone_number')->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(false);
            $table->integer('role_cd')->nullable(false)->default(Constants::CD_ROLE_STUDENT);
            $table->unsignedBigInteger('province_id')->nullable(true);
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->unsignedBigInteger('district_id')->nullable(true);
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->string('street')->nullable(true);
            $table->date('birthday')->nullable(true);
            $table->integer('sex')->nullable(true);
            $table->string('education')->nullable(true);
            $table->integer('job_current_id')->nullable(true);
            $table->string('certificate')->nullable(true);
            $table->string('front_citizen_card')->nullable(true);
            $table->string('back_citizen_card')->nullable(true);
            $table->string('title')->nullable(true);
            $table->string('description')->nullable(true);
            $table->integer('price')->nullable(true);
            $table->integer('type_cd')->nullable(true);
            $table->integer('status_cd')->nullable(false)->default(1);
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
        Schema::dropIfExists('users');
    }
}