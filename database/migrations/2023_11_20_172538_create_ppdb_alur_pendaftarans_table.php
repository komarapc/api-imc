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
        Schema::create('ppdb_alur_pendaftarans', function (Blueprint $table) {
            $table->string('id', 21)->primary();
            $table->string('step_name');
            $table->string('step_description');
            $table->string('step_image');
            $table->string('step_image_url');
            $table->string('link')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_alur_pendaftarans');
    }
};
