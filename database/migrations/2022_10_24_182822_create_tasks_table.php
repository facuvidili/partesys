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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('description', 100);
            $table->string('time'); //10,5 horas
            $table->foreign('daily_report_id')->references('id')->on('daily_reports')->onDelete('set null');
            $table->unsignedBigInteger('daily_report_id')->nullable();
            $table->timestamps();
            $table->unique(['daily_report_id','description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
