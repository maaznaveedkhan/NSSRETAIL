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
        Schema::create('bussinesses_suppliers', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->string('detail')->nullable();
            $table->decimal('purchase')->nullable();
            $table->decimal('payment')->nullable();
            $table->decimal('balance')->nullable();
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
        Schema::dropIfExists('bussinesses_suppliers');
    }
};
