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
        Schema::create('contracts', function (Blueprint $table) { 
            $table->id();
            $table->date('start_date');
            $table->integer('months_duration');
            $table->date('end_date')->nullable();
            $table->float('total_price',9,2);
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->foreign('crew_id')->references('id')->on('crews')->onDelete('set null');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('crew_id')->nullable();
            $table->unique(['crew_id']);
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
        Schema::dropIfExists('contracts');
    }
};
