<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToRidesTable extends Migration
{
    public function up()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->string('email')->nullable(); // Add the email column, making it nullable if needed
        });
    }

    public function down()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->dropColumn('email'); // Drop the email column if rolling back
        });
    }
}
