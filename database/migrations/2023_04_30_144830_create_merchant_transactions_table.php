<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique()->index();
            $table->unsignedBigInteger('merchant_id')->index();
            $table->string('referenceNo');
            $table->string('status')->index();
            $table->string('operation')->index();
            $table->string('errorCode')->nullable();
            $table->string('channel');
            $table->json('customData')->nullable();
            $table->unsignedInteger('chain_id')->nullable();
            $table->unsignedInteger('agent_info_id')->nullable();
            $table->unsignedInteger('fx_transaction_id')->nullable();
            $table->string('code')->nullable();
            $table->string('message')->nullable();
            $table->json('agent')->nullable();
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
        Schema::dropIfExists('merchant_transactions');
    }
}
