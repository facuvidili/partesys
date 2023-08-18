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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->date('work_start_date');
            $table->date('work_end_date');
            $table->time('work_start_time');
            $table->time('work_end_time');
            $table->text('observation');
            $table->float('total',8,2);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('consolidation_id')->references('id')->on('consolidations')->onDelete('set null');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->foreign('crew_id')->references('id')->on('crews')->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('consolidation_id')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('crew_id')->nullable();
            $table->timestamps();
            // $table->unique(['work_start_date', 'crew_id']); //lo dejamos así por ahora capaz necesite end_date
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_reports');
    }
};
