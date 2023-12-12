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
        Schema::create('posts', function (Blueprint $table) {
            $table->string('id', 21)->primary();
            $table->string('title');
            $table->string('slug')->index();
            $table->text('content');
            $table->string('image');
            $table->string('image_url');
            $table->string('type_post_id');
            $table->string('category_id');
            $table->string('status_id');
            $table->string('posted_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->integer('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
