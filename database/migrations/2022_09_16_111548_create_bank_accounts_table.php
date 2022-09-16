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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->nullable();
            $table->string('date')->nullable();
            $table->string('account')->nullable();
            $table->string('account_holder_id')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_holder_phone')->nullable();
            $table->string('account_holder_bank')->nullable();
            $table->string('cheque_img')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('tobe1')->nullable();
            $table->string('tobe2')->nullable();
            $table->string('tobe3')->nullable();
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
        Schema::dropIfExists('bank_accounts');
    }
};
