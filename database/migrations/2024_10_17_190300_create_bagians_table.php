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
        Schema::create('bagians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_bagian');
            $table->string('kode_bagian');
            $table->string('kepala_bagian');
            $table->string('kop');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bagians');
    }
};
