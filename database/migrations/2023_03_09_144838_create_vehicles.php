<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('registration_number', 20)->nullable()->comment('nomer polisi');
            $table->string('name', 50);
            $table->string('merk', 30)->nullable()->comment('merk');            
            $table->string('engine_number', 50)->comment('nomer mesin');
            $table->string('identity_number', 50)->comment('nomer rangka');
            $table->string('owner_name')->nullable()->comment('nama pemilik kendaraan');
            $table->string('registration_year', 4);
            $table->date('purchase_date')->nullable();
            $table->string('vehicle_ownership_number', 50)->nullable()->comment('nomer bpkb');            
            $table->blameable();
            $table->timestamps();
            $table->softDeletes();                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle');
    }
}
