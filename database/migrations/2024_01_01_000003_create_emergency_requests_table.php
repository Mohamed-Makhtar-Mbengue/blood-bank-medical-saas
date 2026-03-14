<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emergency_requests', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('blood_type');
            $table->integer('quantity_ml');
            $table->string('emergency_level');
            $table->text('hospital_details');
            $table->text('notes')->nullable();

            // Correction ici
            $table->foreignId('requested_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('status', ['pending', 'fulfilled', 'cancelled'])->default('pending');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_requests');
    }
};
