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
        Schema::create('money_receive_books', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('detail')->nullable();
            $table->decimal('money_in')->nullable();
            $table->decimal('money_out')->nullable();
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
        Schema::dropIfExists('money_receive_books');
    }
};
