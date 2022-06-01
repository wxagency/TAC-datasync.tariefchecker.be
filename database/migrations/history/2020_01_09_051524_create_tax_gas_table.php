<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxGasTable extends Migration
{
    /** 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('tax_gas', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('backupdate');
            $table->date('date')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_till')->nullable();
            $table->string('dgo')->nullable();
            $table->string('dgo_electrabelname')->nullable();
            $table->string('fuel')->nullable();
            $table->string('segment')->nullable();
            $table->string('VL', 1)->nullable();
            $table->string('WA', 1)->nullable();
            $table->string('BR', 1)->nullable();
            $table->integer('volume_lower')->nullable();
            $table->bigInteger('volume_upper')->nullable();
            $table->float('energy_contribution', 8, 5)->nullable();
            $table->float('federal_contribution', 8, 5)->nullable();
            $table->float('contribution_protected_customers', 8, 5)->nullable();
            $table->float('connection_fee', 8, 5)->nullable();
            $table->float('contribution_public_services', 8, 5)->nullable();
            $table->float('fixed_tax', 8,5)->nullable();
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
        Schema::dropIfExists('tax_gas');
    }
}
