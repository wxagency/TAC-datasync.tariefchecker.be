<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicGasProfessionalsTable extends Migration
{
    /** 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('dynamic_gas_professionals', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('backupdate');
            $table->string('product_id');
            $table->date('date')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_till')->nullable();
            $table->string('supplier')->nullable();
            $table->string('product')->nullable();
            $table->string('fuel')->nullable();
            $table->integer('duration')->nullable();
            $table->string('fixed_indexed')->nullable();
            $table->string('segment')->nullable();
            $table->string('VL', 1)->nullable();
            $table->string('WA', 1)->nullable();
            $table->string('BR', 1)->nullable();
            $table->integer('volume_lower')->nullable();
            $table->bigInteger('volume_upper')->nullable();
            $table->float('price_gas', 8,3)->nullable();
            $table->float('ff', 8,3)->nullable();
            $table->string('prices_url_nl',1000)->nullable();
            $table->string('prices_url_fr',1000)->nullable();
            $table->string('index_name')->nullable();
            $table->string('index_value')->nullable();
            $table->float('coeff', 8,3)->nullable();
            $table->float('term', 8,3)->nullable();
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
        Schema::dropIfExists('dynamic_gas_professionals');
    }
}
