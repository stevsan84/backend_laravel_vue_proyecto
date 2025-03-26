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
        Schema::table('personas', function (Blueprint $table) {
            //
            $table->string("pais",50)->nullable()->after("ci"); 
            //$table->string("pais",50)->nullable(); // solo funciona en sqlite y mysql ->after("ci");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            //
            $table->dropColumn("pais");
        });
    }
};
