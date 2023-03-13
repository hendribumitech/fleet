<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('maintenance_id');            
            $table->text('description');
            $table->timestamps();
            $table->foreign('maintenance_id')->references('id')->on('maintenances')->onUpdate('cascade')->onDelete('restrict');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_services');
    }
}
