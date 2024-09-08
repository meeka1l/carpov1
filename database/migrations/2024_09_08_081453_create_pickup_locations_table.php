<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickupLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('pickup_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ride_id');
            $table->string('pickup_location');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pickup_locations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['ride_id']);
        });

        Schema::dropIfExists('pickup_locations');
    }
}
