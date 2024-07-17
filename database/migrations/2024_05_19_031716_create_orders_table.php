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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('billaddress')->nullable();
            $table->string('product_title')->nullable();
            $table->text('quantity')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('bcandle')->nullable();
            $table->string('scandle')->nullable();
            $table->text('message')->nullable();
            $table->date('deldate')->nullable();
            $table->string('deltime')->nullable();
            $table->string('promocode')->nullable();
            $table->decimal('discount', 8, 2)->default(0.00);
            $table->decimal('newprice', 8, 2);
            $table->string('delmethod')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
