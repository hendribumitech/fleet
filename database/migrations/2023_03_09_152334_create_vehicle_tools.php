<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_tools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('tool_id');
            $table->timestamps();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('tool_id')->references('id')->on('tools')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_tools');
    }
}
