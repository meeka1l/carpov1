<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pickup_locations', function (Blueprint $table) {
            $table->longText('pickup_location')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pickup_locations', function (Blueprint $table) {
            $table->string('pickup_location', 255)->change();
        });
    }
};
