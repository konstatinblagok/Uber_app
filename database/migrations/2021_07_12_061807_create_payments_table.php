<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_pay_id');
            $table->string('payment_transaction_id');
            $table->string('payment_method', 100);
            $table->enum('payment_status', ['Approved', 'Failed'])->default('Approved');
            $table->string('payer_id');
            $table->string('payer_email');
            $table->string('payer_first_name');
            $table->string('payer_last_name');
            $table->string('payee_merchant_id');
            $table->double('total_amount');
            $table->string('currency', 30);
            $table->longText('payment_data');
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
        Schema::dropIfExists('payments');
    }
}
