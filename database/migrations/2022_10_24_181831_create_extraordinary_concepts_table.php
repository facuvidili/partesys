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
        Schema::create('extraordinary_concepts', function (Blueprint $table) {
            $table->id();
            $table->string('name',25);
            $table->enum('type',['descuento','normal']);
            $table->timestamps();
            $table->unique(['name', 'type']); //tipo si es de descuento o no
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extraordinary_concepts');
    }
};
