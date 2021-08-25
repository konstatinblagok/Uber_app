<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCookReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cook_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consumer_user_id');
            $table->unsignedBigInteger('cook_user_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('meal_id');
            $table->double('rating');
            $table->mediumText('comments')->nullable();
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
        Schema::dropIfExists('cook_reviews');
    }
}
