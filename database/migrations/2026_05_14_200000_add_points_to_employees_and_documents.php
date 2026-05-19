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
        Schema::table('employees', function (Blueprint $table) {
            $table->integer('total_points')->default(0)->after('status');
        });

        Schema::table('employee_documents', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('total_points');
        });

        Schema::table('employee_documents', function (Blueprint $table) {
            $table->dropColumn('points');
        });
    }
};
