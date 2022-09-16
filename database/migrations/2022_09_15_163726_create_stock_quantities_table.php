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
        Schema::create('stock_quantities', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->nullable();
            $table->integer('item_id')->nullable();
            $table->decimal('sale_rate')->nullable();
            $table->decimal('purchase_rate')->nullable();
            $table->decimal('qty_in')->nullable();
            $table->decimal('qty_out')->nullable();
            $table->string('detail')->nullable();
            $table->string('date')->nullable();
            $table->string('bill_no')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('party')->nullable();
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
        Schema::dropIfExists('stock_quantities');
    }
};
