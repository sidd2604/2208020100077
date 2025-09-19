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
        Schema::create('urls', function (Blueprint $table) {
        $table->id();
        $table->text('original_url');
        $table->string('shortcode')->unique();
        $table->unsignedBigInteger('clicks')->default(0);
        $table->timestamp('expiry')->nullable();
        $table->timestamps();
    });

    Schema::create('url_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('url_id')->constrained()->onDelete('cascade');
        $table->timestamp('clicked_at');
        $table->string('referrer')->nullable();
        $table->string('location')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
