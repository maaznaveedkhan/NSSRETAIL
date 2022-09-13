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
        Schema::create('bill_books', function (Blueprint $table) {
            $table->id();
            $table->string('business_id')->nullable();
            $table->string('amount')->nullable();
            $table->longText('detail')->nullable();
            $table->date('date')->nullable();
            $table->string('party')->nullable();
            $table->string('item')->nullable();
            $table->string('quantity')->nullable();
            $table->string('rate')->nullable();
            $table->string('method')->nullable();
            $table->string('to_be2')->nullable();
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
        Schema::dropIfExists('bill_books');
    }
};
