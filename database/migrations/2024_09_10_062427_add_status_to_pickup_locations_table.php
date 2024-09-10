<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPickupLocationsTable extends Migration
{
    public function up()
    {
        Schema::table('pickup_locations', function (Blueprint $table) {
            $table->string('status')->default('Pending');
        });
    }

    public function down()
    {
        Schema::table('pickup_locations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}