<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('consumer_billing_info_id');
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('meal_id');
            $table->integer('quantity');
            $table->double('meal_price', 10, 2);
            $table->double('delivery_cost', 10, 2);
            $table->double('net_total_amount', 10, 2);
            $table->unsignedBigInteger('currency_id');
            $table->enum('status', ['Pending', 'Approved', 'Processing', 'Delivered', 'Cancel', 'Completed'])->default('Pending');
            $table->longText('status_remarks')->nullable();
            $table->timestamp('delivery_time');
            $table->timestamp('delivered_at')->nullable();
            $table->boolean('reminder_email')->default(false);
            $table->boolean('admin_email')->default(false);
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
        Schema::dropIfExists('orders');
    }
}
