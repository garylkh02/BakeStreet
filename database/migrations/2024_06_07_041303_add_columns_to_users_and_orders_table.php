<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('loyalty_points')->default(0);
            $table->string('referral_code')->nullable()->unique();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('first_order')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('loyalty_points');
            $table->dropColumn('referral_code');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('first_order');
        });
    }
};
