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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('moderator_id');
            $table->string('mode');
            $table->date('date');
            $table->integer('teams');
            $table->enum('status', ['Active', 'Inactive', 'Pending']);
            $table->time('time');
            $table->decimal('stake', 15, 2);
            $table->text('link')->nullable();
            $table->string('password')->nullable();
            $table->enum('pace', ['Normal', 'Fast', 'Slow'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('moderator_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
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
