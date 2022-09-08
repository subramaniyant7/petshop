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
        Schema::create('deliveryinfo_products', function (Blueprint $table) {
            $table->id('deliveryinfo_product_id');
            $table->integer('deliveryinfo_id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->string('product_name');
            $table->string('product_gram');
            $table->string('total_product_gram');
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
        Schema::dropIfExists('deliveryinfo_products');
    }
};
