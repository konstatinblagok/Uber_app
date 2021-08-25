<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->mediumText('address')->nullable();
            $table->string('apartment_suite_unit', 100)->nullable();
            $table->unsignedBigInteger('city_id');
            $table->string('zip_code', 100)->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('card_number', 30)->nullable();
            $table->string('card_expiry_date', 15)->nullable();
            $table->string('card_cvv', 10)->nullable();
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
        Schema::dropIfExists('billing_infos');
    }
}
