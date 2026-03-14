<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('donors', function (Blueprint $table) {
            $table->string('postal_code')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('donors', function (Blueprint $table) {
            $table->string('postal_code')->nullable(false)->change();
        });
    }
};

