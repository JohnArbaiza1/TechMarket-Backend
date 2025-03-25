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
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('user_pass');
            $table->boolean('published')->default(false);
            $table->unsignedBigInteger('id_membership')->default(1);
            $table->foreign('id_membership')->references('id')->on('tbl_memberships');
            $table->boolean('membership_status')->default(false);
            $table->double('user_rating', 1,2)->default(0);
            $table->string('remenber_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
