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
        Schema::table('turns', function (Blueprint $table) {
            $table->unsignedBigInteger('turn_type_id');
            $table->foreign('turn_type_id')->references('id')->on('turn_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turns', function (Blueprint $table) {
            $table->dropForeign(['turn_type_id']);
            $table->dropColumn('turn_type_id');
        });
    }
};
