<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveClassIdColumnTeachSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teach_subjects', function (Blueprint $table) {
            $table->dropColumn('class_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teach_subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id');
        });   
    }
}
