<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetcostgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('netcostg', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('backupdate');
            $table->date('date')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_till')->nullable();
            $table->string('dgo')->nullable();
            $table->string('dgo_electrabelname')->nullable();
            $table->string('fuel')->nullable();
            $table->string('segment')->nullable();
            $table->string('VL')->nullable();
            $table->string('WA')->nullable();
            $table->string('BR')->nullable();
            $table->string('volume_lower')->nullable();
            $table->string('volume_upper')->nullable();
            $table->string('fixed_term')->nullable();
            $table->string('variable_term')->nullable();
            $table->string('reading_meter_yearly')->nullable();
            $table->string('reading_meter_monthly')->nullable();                
            $table->string('transport')->nullable();            
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
        Schema::dropIfExists('netcostgs');
    }
}
