<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->nullable();
            $table->uuid('register_course_id')->nullable();
            $table->uuid('register_tutor_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('bank_transaction_no')->nullable();
            $table->string('card_type')->nullable();
            $table->string('order_info')->nullable();
            $table->string('pay_date')->nullable();
            $table->string('response_code')->nullable();
            $table->string('tmn_code')->nullable();
            $table->string('transaction_no')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('txn_ref')->nullable();
            $table->string('secure_hash')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 false | 1 true');
            $table->tinyInteger('payment_type')->comment('0 register_course | 1 register_tutor');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('register_course_id')->references('id')->on('register_courses');
            $table->foreign('register_tutor_id')->references('id')->on('request_tutors');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
