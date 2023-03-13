<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('number', 50)->nullable();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->text('path_file')->nullable();
            $table->date('issued_at')->nullable();
            $table->date('expired_at')->nullable();
            $table->blameable();            
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('document_id')->references('id')->on('documents')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_documents');
    }
}
