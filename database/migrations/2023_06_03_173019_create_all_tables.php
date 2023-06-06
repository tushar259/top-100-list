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
        Schema::create('all_tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_name_starts_with')->unique();
            $table->string('headline')->unique();
            $table->string('nav_headline')->unique();
            $table->integer('priority')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_tables');
    }
};
