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
        Schema::create('cash_details', function (Blueprint $table) {
            $table->id();
            $table->string('business_id')->nullable();
            $table->string('cash_id')->nullable();
            $table->string('cash_in')->nullable();
            $table->string('cash_out')->nullable();
            $table->string('amount')->nullable();
            $table->string('detail')->nullable();
            $table->string('date')->nullable();
            $table->string('party')->nullable();
            $table->string('balance')->nullable();
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
        Schema::dropIfExists('cash_details');
    }
};
