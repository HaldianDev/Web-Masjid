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
        Schema::create('prayer_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->date('date')->index();
            $table->string('imsak');
            $table->string('subuh');
            $table->string('syuruk');
            $table->string('dzuhur');
            $table->string('ashar');
            $table->string('maghrib');
            $table->string('isya');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prayer_schedules');
    }
};
