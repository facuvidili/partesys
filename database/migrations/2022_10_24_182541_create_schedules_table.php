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
        Schema::create('schedules', function (Blueprint $table) { //tabla de los dias y horarios de los conceptos hs normales hs 100 etc.
            $table->id();
            $table->string('day',25)->collation('utf8mb4_general_ci');
            $table->string('start_time')->collation('utf8mb4_general_ci');
            $table->string('end_time')->collation('utf8mb4_general_ci');
            $table->foreign('concept_id')->references('id')->on('concepts')->onDelete('set null');
            $table->unsignedBigInteger('concept_id')->nullable();
            $table->timestamps();
            $table->unique(['day', 'start_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
