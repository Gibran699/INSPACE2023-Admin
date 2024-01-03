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
        Schema::create('deskripsis', function (Blueprint $table) {
            $table->increments('id',7);
            $table->enum('content',['sistem informasi','inspace']);
            $table->string('tittle',225);
            $table->string('link',225)->nullable();
            $table->string('foto',225)->nullable();
            $table->text('short_description')->nullable();
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deskripsis');
    }
};
