<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetcostesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('netcoste', function (Blueprint $table) {
            $table->increments('id');
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
            $table->string('price_single')->nullable();
            $table->string('price_day')->nullable();
            $table->string('price_night')->nullable();
            $table->string('price_excl_night')->nullable();
            $table->string('reading_meter')->nullable();
            $table->string('prosumers')->nullable();
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
        Schema::dropIfExists('netcoste');
    }
}
