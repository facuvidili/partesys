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
        Schema::create('cost_extra', function (Blueprint $table) { 
            $table->id();
            $table->float('value',12,2);
            $table->foreign('cost_id')->references('id')->on('costs');
            $table->foreign('extraordinary_concept_id')->references('id')->on('extraordinary_concepts');
            $table->unsignedBigInteger('cost_id')->nullable();
            $table->unsignedBigInteger('extraordinary_concept_id')->nullable();
            $table->unique(['cost_id','extraordinary_concept_id']);
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
        Schema::dropIfExists('cost_extra');
    }
};
