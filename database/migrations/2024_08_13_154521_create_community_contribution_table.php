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
        Schema::create('community_contribution', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('community_id');
            $table->foreign('community_id')->references('id')->on('communities');
            $table->uuid('contribution_id');
            $table->foreign('contribution_id')->references('id')->on('contributions');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_contribution');
    }
};
