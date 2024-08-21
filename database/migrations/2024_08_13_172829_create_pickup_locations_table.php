<?php

// In create_pickup_locations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickupLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('pickup_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Assuming you have a users table
            $table->unsignedBigInteger('ride_id'); // Assuming each pickup location is linked to a ride
            $table->string('pickup_location');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pickup_locations');
    }
}
