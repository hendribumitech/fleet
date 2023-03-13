<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id');
            $table->datetime('start');
            $table->datetime('end')->nullable();
            $table->text('description')->nullable();
            $table->string('status', 25)->nullable()->default('On Progress');
            $table->timestamps();
            $table->blameable();
            $table->softDeletes();
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
        Schema::dropIfExists('maintenances');
    }
}
