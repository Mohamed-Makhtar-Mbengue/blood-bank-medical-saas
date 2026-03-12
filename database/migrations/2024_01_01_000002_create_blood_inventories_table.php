<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('blood_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->integer('quantity_ml');
            $table->date('expiration_date');
            $table->unsignedInteger('donation_id')->nullable();
            $table->enum('status', ['available', 'reserved', 'expired', 'used']);
            $table->timestamps();

            $table->foreign('donation_id')
                  ->references('id')
                  ->on('donations')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blood_inventories');
    }
}