<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneBirthdateAddressToUsers extends Migration
{
    /**
     * Chạy các migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('email');
            $table->date('birthdate')->nullable()->after('phone_number');
            $table->string('address')->nullable()->after('birthdate');
        });
    }

    /**
     * Đảo ngược các migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'birthdate', 'address']);
        });
    }
}