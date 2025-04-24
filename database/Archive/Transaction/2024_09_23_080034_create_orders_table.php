<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requester_id'); // User ID of the sender
            $table->unsignedBigInteger('receiver_id'); // User ID of the receiver
            $table->unsignedInteger('amount'); // Amount of tokens being transferred
            $table->unsignedBigInteger('transaction_id')->nullable(); // Link to the transaction
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Order status
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('requester_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('restrict');
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
