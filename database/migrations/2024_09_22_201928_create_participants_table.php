<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('grouped')->default(false);
            $table->boolean('grouped_name')->nullable();
            $table->integer('user_score')->default(0)->nullable();
            $table->integer('moderator_score')->default(0)->nullable();
            $table->string('status')->default("Active");
            $table->decimal('payout',15,2)->default(0);
            $table->json('results')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('match_id')->references('id')->on("matches")
                ->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on("users")
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
