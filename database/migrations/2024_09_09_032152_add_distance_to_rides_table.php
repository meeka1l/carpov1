<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistanceToRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->decimal('distance', 8, 2)->nullable(); // Adjust precision as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->dropColumn('distance');
        });
    }
}
