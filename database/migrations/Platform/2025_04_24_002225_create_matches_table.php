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
        Schema::create('matches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('match_type_id')->constrained()->cascadeOnDelete();
            $table->decimal('stake', 10, 2)->default(0);
            $table->decimal('payout', 10, 2)->default(0);
            $table->decimal('service_fee', 10, 2)->default(0);
            $table->integer('timer')->default(10); // mins
            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled', 'disputed'])->default('pending');
            $table->json('config')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
