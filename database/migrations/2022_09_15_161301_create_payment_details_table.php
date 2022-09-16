<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id('payment_detail_id');
            $table->string('orderId');
            $table->string('orderAmount');
            $table->string('referenceId');
            $table->string('txStatus');
            $table->string('paymentMode');
            $table->string('txMsg');
            $table->string('txTime');
            $table->string('signature');
            $table->integer('status');
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
        Schema::dropIfExists('payment_details');
    }
};
