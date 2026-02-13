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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();

            // Relationship to Patient
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('sample_code')->unique();
            $table->string('sample_type');
            $table->enum('status',[
                'pending',
                'received',
                'processing',
                'completed',
                'rejected'
            ])->default('pending');

            $table->timestamp('received_at')->nullable();

            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
