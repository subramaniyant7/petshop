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
        Schema::create('pets_master_calculation', function (Blueprint $table) {
            $table->id('master_id');
            $table->integer('category_id');
            $table->integer('activity_level');
            $table->integer('neuter');
            $table->integer('goal');
            $table->string('weight');
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
        Schema::dropIfExists('pets_master_calculation');
    }
};
