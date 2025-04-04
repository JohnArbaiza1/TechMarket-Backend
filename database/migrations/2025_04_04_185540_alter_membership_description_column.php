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
        Schema::table('tbl_memberships', function (Blueprint $table) {
            $table->text('membership_description')->change(); // Cambiar a tipo text
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_memberships', function (Blueprint $table) {
            $table->string('membership_description')->change(); // Volver a tipo string si es necesario
        });
    }
};
