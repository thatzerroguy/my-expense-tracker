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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('source');
            $table->decimal('amount', 10, 2);
            $table->date('date');

            // Recurring fields
            $table->boolean('is_recurring')->default(false);
            $table->string('frequency')->nullable(); // e.g., daily, weekly, monthly, yearly
            $table->integer('interval')->nullable(); // e.g., 1 (every 1 month)
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
