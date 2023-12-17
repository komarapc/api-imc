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
        Schema::create('imc_sub_program_galeries', function (Blueprint $table) {
            $table->string('id', 21)->primary();
            $table->string('sub_program_id', 21);
            $table->string('file_name');
            $table->string('image_url');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imc_sub_program_galeries');
    }
};
