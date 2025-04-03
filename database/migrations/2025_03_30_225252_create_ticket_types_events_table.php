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
        Schema::create('ticket_types_events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('ticket_type')->constrained('ticket_types');
            $table->foreignId('event_id')->constrained('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_types_events');
    }
};
