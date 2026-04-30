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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            // Link directly to the contract (AssignmentService)
            $table->foreignId('assignment_service_id')->constrained()->onDelete('cascade');
            
            $table->integer('stars'); // 1 to 5
            $table->text('comment')->nullable(); // Optional text review
            
            $table->timestamps(); // Automatically handles the 'date' column you had in your schema
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
