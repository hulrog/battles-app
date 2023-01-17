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
        Schema::create('battles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('numbers1');
            $table->integer('numbers2');
            $table->string('description')->nullable();
            $table->timestamp('date')->nullable();
            $table->foreignId('map_id')->default("0");
            $table->foreignId('player1_id')->default("0");
            $table->foreignId('player2_id')->default("0");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('battles');
    }
};
