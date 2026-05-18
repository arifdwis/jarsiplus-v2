<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laman', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_operator')->nullable();
            $table->string('label')->nullable();
            $table->longText('content')->nullable();
            $table->string('slug')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laman');
    }
};
