<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDistrictIdColumnTeachPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teach_places', function (Blueprint $table) {
            $table->dropColumn('district_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teach_places', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id');
        });   
    }
}
