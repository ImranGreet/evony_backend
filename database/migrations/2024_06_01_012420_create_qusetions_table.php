<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qusetions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('primary_motivations_weight');
            $table->string('have_target_weight');
            $table->string('target_weight');
            $table->string('how_struggled_weight');
            $table->string('approaches_methods');
            $table->string('your_main_challenges');
            $table->string('suffer_following');
            $table->string('pregnant_lactic');
            $table->string('diagnosed_conditions');
            $table->string('taking_medications');
            $table->string('taking_Ozempic');
            $table->string('twentyFive_starting_dose');
            $table->string('list_current_medications');
            $table->string('allergic_to_these');
            $table->string('allergies_none');
            $table->string('current_weight_height');
            $table->string('BMI_range');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qusetions');
    }
};
