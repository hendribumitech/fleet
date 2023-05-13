<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleChecklistItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('vehicle_checklist_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_checklist_id');
            $table->unsignedBigInteger('checklist_item_id');
            $table->enum('status', ['OK', 'NO']);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->blameable();
            $table->softDeletes();

            $table->foreign('vehicle_checklist_id')->on('vehicle_checklists')->references('id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('checklist_item_id')->on('checklist_items')->references('id')->onUpdate('cascade')->onDelete('restrict');
            $table->unique(['vehicle_checklist_id', 'checklist_item_id'], 'vci_unique_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_checklist_items');
    }
}
