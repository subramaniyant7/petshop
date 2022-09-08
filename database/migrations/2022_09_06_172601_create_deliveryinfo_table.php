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
        Schema::create('deliveryinfo', function (Blueprint $table) {
            $table->id('deliveryinfo_id');
            $table->integer('order_id');
            $table->integer('user_id');
            $table->string('perday_meal');
            $table->string('total_days');
            $table->string('total_gram');
            $table->string('delivery_date');
            $table->string('status');
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
        Schema::dropIfExists('deliveryinfo');
    }
};
