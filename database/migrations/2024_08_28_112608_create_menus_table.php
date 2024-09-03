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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('text')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('target')->nullable();
            $table->string('link')->nullable();
            $table->string('icon')->nullable();
            $table->tinyInteger('order')->nullable();
            $table->boolean('active')->default(false);
            $table->foreignId('menu_type_id')->references('id')->on('menu_types');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
