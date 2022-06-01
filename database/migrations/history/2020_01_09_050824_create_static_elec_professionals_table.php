<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticElecProfessionalsTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('static_elec_professionals', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('backupdate');
            $table->string('product_id');
            $table->string('acticve')->nullable();
            $table->string('partner')->nullable();
            $table->string('supplier')->nullable();
            $table->string('product_name_NL')->nullable();
            $table->string('product_name_FR')->nullable();
            $table->string('fuel')->nullable();
            $table->integer('duration')->nullable();
            $table->string('fixed_indiable')->nullable();
            $table->string('green_percentage')->nullable();
            $table->string('origin')->nullable();
            $table->string('segment')->nullable();
            $table->string('VL')->nullable();
            $table->string('WA')->nullable();
            $table->string('BR')->nullable();
            $table->string('service_level_payment')->nullable();
            $table->string('service_level_invoicing')->nullable();
            $table->string('service_level_contact')->nullable();
            $table->string('FF_pro_rata')->nullable();
            $table->integer('inv_period')->nullable();
            $table->string('customer_condition')->nullable();
            $table->string('subscribe_url_NL',1000)->nullable();
            $table->longText('info_NL')->nullable();
            $table->string('tariff_description_NL')->nullable();
            $table->string('terms_NL')->nullable();
            $table->string('subscribe_url_FR',1000)->nullable();
            $table->longText('info_FR')->nullable();
            $table->string('tariff_description_FR')->nullable();
            $table->string('terms_FR')->nullable();
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
        Schema::dropIfExists('static_elec_professionals');
    }
}
