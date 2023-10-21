<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->primary('id');
            $table->uuid('id')->comment('ID');
            $table->string('title')->nullable(false);
            $table->uuid('user_id')->nullable(false);
            $table->string('image')->nullable(false);
            $table->integer('type_cd')->nullable(false);
            $table->string('description')->nullable(false);
            $table->longText('content')->nullable(false);
            $table->integer('view')->nullable(false)->default(0);
            $table->integer('like')->nullable(false)->default(0);
            $table->jsonb('tags')->nullable(false);
            $table->timestampTz('deleted_at')->nullable(true);
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
        Schema::dropIfExists('posts');
    }
}
