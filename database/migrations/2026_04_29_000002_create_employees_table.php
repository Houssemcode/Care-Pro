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
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Matches: id INT PRIMARY KEY AUTO_INCREMENT
            
            // Matches: user_id INT, FOREIGN KEY (user_id) REFERENCES User(id)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('experience')->nullable();
            $table->string('diploma')->nullable();
            $table->string('description')->nullable();
            $table->enum('status', ['pending', 'active', 'suspended'])->default('pending');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
