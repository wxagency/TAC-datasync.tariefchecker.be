<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostalcodeDgoElectricitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postalcode_dgo_electricities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('distribution_id')->unique();;
            $table->string('netadmin_zip')->nullable();
            $table->string('netadmin_city')->nullable();
            $table->string('netadmin_subcity')->nullable();
            $table->string('product')->nullable();
            $table->string('grid_operational')->nullable();
            $table->string('gas_H_L')->nullable();
            $table->string('DNB')->nullable();
            $table->string('netadmin_website')->nullable();
            $table->string('TNB')->nullable();
            $table->string('language_code')->nullable();
            $table->string('region')->nullable();         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postalcode_dgo_electricity');
    }
}
