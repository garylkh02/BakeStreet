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
        Schema::table('cakes', function (Blueprint $table) {
            $table->tinyInteger('selfcollect')->default(0); // Default to 0 (false) for unchecked
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cakes', function (Blueprint $table) {
            $table->dropColumn('selfcollect');
        });
    }
};
