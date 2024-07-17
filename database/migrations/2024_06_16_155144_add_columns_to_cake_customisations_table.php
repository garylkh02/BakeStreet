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
        Schema::table('cake_customisations', function (Blueprint $table) {
            $table->string('photo', 300);
            $table->string('size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cake_customisations', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->dropColumn('size');
        });
    }
};
