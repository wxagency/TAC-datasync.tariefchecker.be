<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticPackResidentialsTable extends Migration
{
    /** 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('static_pack_residentials', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('backupdate');
            $table->string('pack_id')->nullable();
            $table->string('pack_name_NL')->nullable();
            $table->string('pack_name_FR')->nullable();
            $table->string('active')->nullable();
            $table->string('partner')->nullable();
            $table->string('pro_id_E')->nullable();
            $table->string('pro_id_G')->nullable();
            $table->longText('URL_NL')->nullable();
            $table->longText('info_NL')->nullable();
            $table->string('tariff_description_NL',2000)->nullable();
            $table->longText('URL_FR')->nullable();
            $table->longText('info_FR')->nullable();
            $table->string('tariff_description_FR',2000)->nullable();
            $table->string('check_elec')->nullable();
            $table->string('check_gas')->nullable();
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
        Schema::dropIfExists('static_pack_residentials');
    }
}
