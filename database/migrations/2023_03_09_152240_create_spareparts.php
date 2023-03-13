<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpareparts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 50)->unique()->comment('isi dengan code external sparepart dari accurate');
            $table->string('name', 100);
            $table->text('description')->nullable();            
            $table->timestamps();
            $table->blameable();
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
        Schema::dropIfExists('spareparts');
    }
}
