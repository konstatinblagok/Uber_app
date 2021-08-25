<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('food_type_id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('currency_id');
            $table->double('price', 10, 2)->comment = 'This price belongs to one portion';
            $table->integer('portions')->default(0);
            $table->date('delivery_date')->nullable();
            $table->integer('reserved_portions')->default(0);
            $table->boolean('mail_to_cook')->default(false);
            $table->boolean('expired')->default(false);
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('meals');
    }
}
