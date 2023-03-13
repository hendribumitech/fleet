<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVehicleIdDriver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function(Blueprint $table){
            $table->unsignedBigInteger('vehicle_id')->nullable()->after('code');
            $table->foreign('vehicle_id', 'fk_driver_vehicle_1')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drivers', function(Blueprint $table){
            $table->dropForeignKey('fk_driver_vehicle_1');
            $table->dropColumn('vehicle_id');
        });
    }
}
