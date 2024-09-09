<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDistanceToDistanceKmInRidesTable extends Migration
{
    public function up()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->renameColumn('distance', 'distance_km');
        });
    }

    public function down()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->renameColumn('distance_km', 'distance');
        });
    }
}
