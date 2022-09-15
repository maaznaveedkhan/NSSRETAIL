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
        Schema::create('cash_books', function (Blueprint $table) {
            $table->id();
            $table->string('business_id')->nullable();
            $table->date('date')->nullable();
            $table->string('amount')->nullable();
            $table->decimal('cash_in')->nullable();
            $table->decimal('cash_out')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('party')->nullable();
            $table->string('detail')->nullable();
            $table->decimal('daily_balance')->nullable();
            $table->decimal('balance')->nullable();
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
        Schema::dropIfExists('cash_books');
    }
};
