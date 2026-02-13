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
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();

            // Link to Sample
            $table->foreignId('sample_id')->constrained()->cascadeOnDelete();
            $table->string('test_name');

            // Workflow status: pending, in_progress, completed, failed
            $table->enum('status', [
                'pending',
                'assigned',
                'in_progress',
                'completed',
                'rejected'
            ])->default('pending');

            // User assigned to perform the test
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('completed_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
    }
};
