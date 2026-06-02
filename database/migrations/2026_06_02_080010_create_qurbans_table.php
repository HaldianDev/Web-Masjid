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
        Schema::create('qurbans', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('participant_name');
            $table->string('phone')->nullable();
            $table->enum('type', ['sapi', 'kambing']);
            $table->integer('group_number')->nullable();
            $table->decimal('amount_paid', 15, 2)->default(0);
            $table->enum('status', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qurbans');
    }
};