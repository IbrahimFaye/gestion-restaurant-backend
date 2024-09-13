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
        DB::statement('ALTER TABLE burgers ALTER COLUMN prix TYPE double precision USING prix::double precision');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('burger', function (Blueprint $table) {
            //
        });
    }
};
