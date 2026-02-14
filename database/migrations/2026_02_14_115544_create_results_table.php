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
        Schema::create('results', function (Blueprint $table) {
            $table->id();

            // Link to lab test
            $table->foreignId('lab_test_id')->constrained()->cascadeOnDelete()->index();

            $table->text('result_value');
            $table->string('reference_range')->nullable();
            $table->string('remarks')->nullable();
            
            // Pathologist who verifies the result
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->index();
            $table->timestamp('verified_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
