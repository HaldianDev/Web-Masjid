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
        Schema::create('zis_records', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['zakat_fitrah_uang', 'zakat_fitrah_beras', 'zakat_maal', 'infaq', 'sedekah']);
            $table->enum('person_type', ['muzakki', 'mustahik']);
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->decimal('amount_money', 15, 2)->nullable();
            $table->decimal('amount_rice', 8, 2)->nullable(); // in kg
            $table->date('date_recorded')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zis_records');
    }
};
