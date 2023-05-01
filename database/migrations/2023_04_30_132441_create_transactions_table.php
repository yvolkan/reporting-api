<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique()->index();
            $table->unsignedBigInteger('client_id')->index();
            $table->unsignedBigInteger('client_card_id')->index();
            $table->unsignedBigInteger('client_billing_address_id')->index();
            $table->unsignedBigInteger('client_shipping_address_id')->index();
            $table->unsignedBigInteger('merchant_id')->index();
            $table->unsignedBigInteger('acquirer_id')->index();
            $table->unsignedBigInteger('merchant_transaction_id')->index();
            $table->unsignedDouble('originalAmount', 10, 4);
            $table->string('originalCurreny', 4);
            $table->json('ipn')->nullable();
            $table->boolean('refundable', 0);
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
        Schema::dropIfExists('transactions');
    }
}
