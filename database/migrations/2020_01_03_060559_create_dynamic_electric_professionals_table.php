<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicElectricProfessionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_electric_professionals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id')->unique();
            $table->date('date')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_till')->nullable();
            $table->string('supplier')->nullable();
            $table->string('product')->nullable();
            $table->string('fuel')->nullable();
            $table->integer('duration')->nullable();
            $table->string('fixed_indexed')->nullable();
            $table->string('customer_segment')->nullable();
            $table->string('VL', 1)->nullable();
            $table->string('WA', 1)->nullable();
            $table->string('BR', 1)->nullable();
            $table->integer('volume_lower')->nullable();
            $table->bigInteger('volume_upper')->nullable();
            $table->float('price_single', 8,3)->nullable();
            $table->float('price_day', 8,3)->nullable();
            $table->float('price_night', 8,3)->nullable();
            $table->float('price_excl_night', 8,3)->nullable();
            $table->float('ff_single', 8,3)->nullable();
            $table->float('ff_day_night', 8,3)->nullable();
            $table->float('ff_excl_night', 8,3)->nullable();
            $table->float('gsc_vl', 8,3)->nullable();
            $table->float('wkc_vl', 8,3)->nullable();
            $table->float('gsc_wa', 8,3)->nullable();
            $table->float('gsc_br', 8,3)->nullable();
            $table->string('prices_url_nl',1000)->nullable();
            $table->string('prices_url_fr',1000)->nullable();
            $table->string('index_name')->nullable();
            $table->string('index_value')->nullable();
            $table->float('coeff_single', 8,3)->nullable();
            $table->float('term_single', 8,3)->nullable();
            $table->float('coeff_day', 8,3)->nullable();
            $table->float('term_day', 8,3)->nullable();
            $table->float('coeff_night', 8,3)->nullable();
            $table->float('term_night', 8,3)->nullable();
            $table->float('coeff_excl', 8,3)->nullable();
            $table->float('term_excl', 8,3)->nullable();
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
        Schema::dropIfExists('dynamic_electric_professionals');
    }
}
