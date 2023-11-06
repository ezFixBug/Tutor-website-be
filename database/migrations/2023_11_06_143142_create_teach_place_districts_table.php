<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachPlaceDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teach_place_districts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teach_place_id');
            $table->unsignedBigInteger('district_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('teach_place_id')->references('id')->on('teach_places')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teach_place_districts');
    }
}
