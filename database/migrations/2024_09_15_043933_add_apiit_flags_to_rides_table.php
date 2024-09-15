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
    Schema::table('rides', function (Blueprint $table) {
        $table->boolean('from_apiit')->default(0);
        $table->boolean('to_apiit')->default(0);
    });
}

public function down()
{
    Schema::table('rides', function (Blueprint $table) {
        $table->dropColumn('from_apiit');
        $table->dropColumn('to_apiit');
    });
}

};
