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
        Schema::create('mail_box', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // Usuario que envía
        $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // Usuario que recibe
        $table->text('message'); // Contenido del mensaje
        $table->boolean('is_read')->default(false);
        $table->timestamps(); // Registra cuándo se envió el mensaje
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_box');
    }
};
