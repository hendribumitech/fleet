<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceSpareparts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_spareparts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('maintenance_id');
            $table->unsignedBigInteger('sparepart_id');
            $table->decimal('quantity', 8, 2, true)->nullable()->default(1);            
            $table->timestamps();
            $table->foreign('maintenance_id')->references('id')->on('maintenances')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_spareparts');
    }
}
