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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('donor_phone')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('payment_method'); // e.g. qris, bca, mandiri, gopay, ovo
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('reference_id')->unique();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
