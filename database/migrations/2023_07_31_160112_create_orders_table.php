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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('year_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->integer('portions')->nullable();
            $table->boolean('take_away')->nullable();
            $table->integer('sauces')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('money_collected')->nullable();
            $table->integer('to_collect')->nullable();
            $table->bool('mp')->nullable();
            $table->string('last_edition')->nullable();
            // $table->string('comment');   // Analizar si es necesario
            $table->timestamps();


            $table->foreign('clients')->references('client_id')->on('id');
            $table->foreign('years')->references('year_id')->on('id');
            $table->foreign('users')->references('user_id')->on('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
