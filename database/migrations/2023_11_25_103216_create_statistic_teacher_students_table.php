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
        Schema::create('statistic_teacher_students', function (Blueprint $table) {
            $table->string('tahun_ajaran_kode')->primary();
            $table->integer('jumlah_murid_tk');
            $table->integer('jumlah_murid_sd');
            $table->integer('jumlah_murid_smp');
            $table->integer('jumlah_murid_sma')->nullable();
            $table->integer('jumlah_guru_karyawan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic_teacher_students');
    }
};
