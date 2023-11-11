<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachSubjectClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teach_subject_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teach_subject_id');
            $table->unsignedBigInteger('class_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('teach_subject_id')->references('id')->on('teach_subjects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teach_subject_classes');
    }
}
