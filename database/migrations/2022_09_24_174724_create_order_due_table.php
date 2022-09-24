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
        Schema::create('order_due', function (Blueprint $table) {
            $table->id('order_due_id');
            $table->integer('user_id');
            $table->integer('parent_order_id');
            $table->integer('order_id');
            $table->string('transactionMonth');
            $table->string('paymentId');
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
        Schema::dropIfExists('order_due');
    }
};
