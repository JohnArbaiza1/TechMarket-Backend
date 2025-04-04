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
        Schema::create('tbl_memberships', function (Blueprint $table) {
            $table->id();
            $table->string('membership_name');
            $table->double('price', 8, 2);
            $table->text('membership_description');
            $table->boolean('unlimited_applications')->default(false);
            $table->boolean('unlimited_publications')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
