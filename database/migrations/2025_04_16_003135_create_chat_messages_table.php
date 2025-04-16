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
        Schema::create('tbl_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user_one');
            $table->foreign('id_user_one')->references('id')->on('tbl_users');
            $table->unsignedBigInteger('id_user_two');
            $table->foreign('id_user_two')->references('id')->on('tbl_users');
            $table->string('message');
            $table->string('message_status')->default('Enviado');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_chat_messages');
    }
};
