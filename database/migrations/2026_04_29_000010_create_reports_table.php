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
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade');
        $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
        $table->foreignId('family_id')->constrained('families')->onDelete('cascade');        
        $table->string('report_reason');
        $table->text('description');
        $table->enum('status', ['active', 'resolved'])->default('active');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
