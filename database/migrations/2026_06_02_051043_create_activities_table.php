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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('category'); // e.g. pengajian, tablig_akbar, ramadan, santunan, pelatihan
            $table->date('event_date')->index();
            $table->string('event_time'); // e.g. "09:00 - 11:30" or "Setelah Ashar"
            $table->string('speaker')->nullable();
            $table->string('location');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
