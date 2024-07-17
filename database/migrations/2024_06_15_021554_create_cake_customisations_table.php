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
        Schema::create('cake_customisations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bakery_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2)->default(88.80); // Set the default price here
            $table->string('category_id');
            $table->string('toppings_id');
            $table->string('flavours_id');
            $table->date('deldate')->nullable();
            $table->string('deltime')->nullable();
            $table->string('message_on_cake')->nullable();
            $table->string('message')->nullable();
            $table->string('bcandle')->nullable();
            $table->string('scandle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cake_customisations');
    }
};
