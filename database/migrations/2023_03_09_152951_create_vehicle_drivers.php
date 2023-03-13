<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleDrivers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('vehicle_drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamps();
            $table->blameable();
            $table->softDeletes();
            $table->foreign('driver_id')->references('id')->on('drivers')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_drivers');
    }
}
