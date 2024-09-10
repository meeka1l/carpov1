<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pickup_locations', function (Blueprint $table) {
            $table->string('status')->default('pending'); // Add a status column with a default value
        });
    }
    
    public function down()
    {
        Schema::table('pickup_locations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
    
};
