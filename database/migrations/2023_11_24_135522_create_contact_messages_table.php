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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->string('id', 21)->primary();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number');
            $table->text('message');
            $table->string('status_code');
            $table->boolean('isRead')->nullable();
            $table->boolean('isStarred')->nullable();
            $table->boolean('isSpam')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
