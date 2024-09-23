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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id'); // Foreign key for the user
            $table->unsignedBigInteger('receiver_id'); // Foreign key for the user
            $table->decimal('amount', 15, 2); // Amount of the transaction
            $table->string('transaction_type'); // e.g., 'credit', 'debit'
            $table->string('description'); // e.g., 'credit', 'debit'
            $table->string('ref')->nullable(); // e.g., 'credit', 'debit'
            $table->string('status')->default('pending'); // Status of the transaction
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
