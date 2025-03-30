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
        Schema::create('tbl_publications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('publication_description');
            $table->string('publication_image')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('tbl_users');
            $table->integer('quota')->default(1);
            $table->string('publication_status')->default('Disponible');
            $table->double('publication_rating', 1,2)->default(0);
            $table->string('tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
