<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidesTable extends Migration
{
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_number');
            $table->string('vehicle_color');
            $table->string('vehicle_model');
            $table->unsignedBigInteger('navigator_id');
            $table->string('start_location');
            $table->string('end_location');
            $table->timestamps();
            $table->unsignedBigInteger('navigator_id')->nullable()->change(); // Allow NULL values
             // Foreign key constraint (if navigator_id references another table)
    $table->foreign('navigator_id')->references('id')->on('users')->onDelete('cascade');
    

        });

        Schema::create('ride_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ride_id');
            $table->unsignedBigInteger('user_id');
            $table->string('pickup_location')->nullable();
            $table->timestamps();

            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ride_user');
        Schema::dropIfExists('rides');
    }
}
