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
        Schema::table('services', function (Blueprint $table) {
            $table->text('note')->nullable()->after('active');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->text('note')->nullable()->after('active');
        });
        Schema::table('testimonials', function (Blueprint $table) {
            $table->text('note')->nullable()->after('active');
        });
        Schema::table('shortened_urls', function (Blueprint $table) {
            $table->text('note')->nullable()->after('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('note');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('note');
        });
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('note');
        });
        Schema::table('shortened_urls', function (Blueprint $table) {
            $table->string('note')->nullable()->change();
        });
    }
};
