<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id');  // Pour les versions anciennes
            $table->unsignedInteger('donor_id');
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->date('donation_date');
            $table->integer('quantity_ml');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'completed', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('donor_id')
                  ->references('id')
                  ->on('donors')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('donations');
    }
}