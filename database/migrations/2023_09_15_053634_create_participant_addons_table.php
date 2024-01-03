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
        Schema::create('participant_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_ticket_id')->constrained('participant_tickets')->onDelete('cascade');
            $table->foreignId('addons_id')->constrained('addons')->onDelete('cascade');
            $table->integer('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_addons');
    }
};
