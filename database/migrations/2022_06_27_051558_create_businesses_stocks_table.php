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
        Schema::create('businesses_stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_unit')->nullable();
            $table->decimal('sale_rate')->nullable();
            $table->decimal('purchase_rate')->nullable();
            $table->string('detail')->nullable();
            $table->decimal('in')->nullable();
            $table->decimal('out')->nullable();
            $table->decimal('balance')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('party')->nullable();
            $table->string('bill')->nullable();
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
        Schema::dropIfExists('businesses_stocks');
    }
};
