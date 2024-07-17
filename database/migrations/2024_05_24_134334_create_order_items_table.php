<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('cake_id')->constrained()->onDelete('cascade');
            $table->string('product_title');
            $table->decimal('price', 8, 2);
            $table->text('quantity')->nullable();
            $table->string('bcandle')->nullable();
            $table->string('scandle')->nullable();
            $table->text('message')->nullable();
            $table->date('deldate')->nullable();
            $table->string('deltime')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
