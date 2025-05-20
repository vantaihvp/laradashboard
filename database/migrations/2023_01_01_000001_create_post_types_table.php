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
        Schema::create('post_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->string('label_singular');
            $table->string('description')->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('has_archive')->default(true);
            $table->boolean('hierarchical')->default(false);
            $table->boolean('show_in_menu')->default(true);
            $table->boolean('show_in_nav_menus')->default(true);
            $table->boolean('supports_title')->default(true);
            $table->boolean('supports_editor')->default(true);
            $table->boolean('supports_thumbnail')->default(true);
            $table->boolean('supports_excerpt')->default(true);
            $table->boolean('supports_custom_fields')->default(true);
            $table->json('taxonomies')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_types');
    }
};
