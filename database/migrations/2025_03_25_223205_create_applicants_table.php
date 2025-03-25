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
        Schema::create('tbl_applicants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_publication');
            $table->foreign('id_publication')->references('id')->on('tbl_publications');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('tbl_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
