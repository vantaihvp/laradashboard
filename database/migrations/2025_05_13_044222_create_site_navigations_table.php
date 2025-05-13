<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_navigations', function (Blueprint $table) {
            $table->id();
            $table->string("menu_label");
            $table->enum('menu_type', ['frontend', 'backend'])->default('backend');
            $table->text("link")->nullable();
            $table->integer('page_id')->nullable();
            $table->string("css_class")->nullable();
            $table->string("css_id")->nullable();
            $table->integer("menu_order")->default(0);
            $table->boolean("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_navigations');
    }
};
