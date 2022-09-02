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
        Schema::create('order_details_temp', function (Blueprint $table) {
            $table->id('order_id');
            $table->integer('user_id');
            $table->integer('pets_master_id');
            $table->string('totalGramNeedtoBuy');
            $table->string('defaultProductCalc');
            $table->string('remainingGramToBuy');
            $table->string('remainingDays');
            $table->string('totalGram');
            $table->string('totalDays');
            $table->string('totalPrice');
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
        Schema::dropIfExists('order_details_temp');
    }
};
