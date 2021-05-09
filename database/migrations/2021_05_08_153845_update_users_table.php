<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable()->after('password');
            $table->string('picture_url')->after('address');
            $table->string('phone')->after('picture_url');
            $table->string('biography')->after('phone');
            $table->string('user_type')->after('biography');
            $table->foreign('user_type')->references('id')->on('user_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('picture_url');
            $table->dropColumn('phone');
            $table->dropColumn('biography');
            $table->dropForeign('users_user_type_foreign');
            $table->dropColumn('user_type');
        });
    }
}
