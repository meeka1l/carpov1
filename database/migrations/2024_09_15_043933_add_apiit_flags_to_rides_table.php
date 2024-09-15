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
        $table->string('apiit_route')->nullable();
    });
}

public function down()
{
    Schema::table('rides', function (Blueprint $table) {
        $table->dropColumn('apiit_route');
    });
}

};
