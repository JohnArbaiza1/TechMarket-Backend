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
        //editar una columna de la tabla publications
        Schema::table('tbl_publications', function (Blueprint $table) {
            $table->text('publication_description')->change(); // Cambiar el tipo de dato a text
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_publications', function (Blueprint $table) {
            $table->string('publication_description', 255)->change(); // Revertir el tipo de dato a string
        });
    }
};
