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
        Schema::create('pets_master_details', function (Blueprint $table) {
            $table->id('pets_master_id');
            $table->integer('user_id');
            $table->integer('breed_type');
            $table->integer('breed_name');
            $table->string('breed_gender');
            $table->string('breed_dob');
            $table->string('breed_weight');
            $table->integer('breed_activity_level')->nullable();
            $table->integer('breed_freedom_level')->nullable();
            $table->integer('breed_neutered');
            $table->integer('breed_weight_motive');
            $table->integer('breed_allergies');
            $table->string('breed_allergies_info');
            $table->integer('breed_health_condition');
            $table->string('breed_health_condition_info');
            $table->integer('breed_nursing')->nullable();
            $table->string('breed_nursing_info');
            $table->string('breed_additional_note');
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
        Schema::dropIfExists('pets_master_details');
    }
};
