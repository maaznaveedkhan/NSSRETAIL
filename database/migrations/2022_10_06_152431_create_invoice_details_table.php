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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->string('party')->nullable();
            $table->integer('business_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->date('date')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('detail')->nullable();
            $table->string('rate')->nullable();
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('invoice_details');
    }
};
