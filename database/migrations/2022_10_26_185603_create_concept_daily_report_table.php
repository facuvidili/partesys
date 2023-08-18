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
        Schema::create('concept_daily_report', function (Blueprint $table) {
            $table->id();
            $table->float('amount',5,2); //cantidad de conceptos
            $table->float('sub_total',9,2);
            $table->foreign('daily_report_id')->references('id')->on('daily_reports')->onDelete('set null');
            $table->foreign('concept_id')->references('id')->on('concepts')->onDelete('set null');
            $table->unsignedBigInteger('daily_report_id')->nullable();
            $table->unsignedBigInteger('concept_id')->nullable();
            $table->timestamps();
            $table->unique(['daily_report_id','concept_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concept_daily_report');
    }
};
