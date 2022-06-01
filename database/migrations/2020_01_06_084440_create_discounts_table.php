<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('discountId');
            $table->string('supplier')->nullable();
            $table->date('discountCreated');
            $table->date('startdate');
            $table->date('enddate');
            $table->string('customergroup')->nullable();
            $table->integer('volume_lower')->nullable();
            $table->bigInteger('volume_upper')->nullable();
            $table->string('discountType')->nullable();
            $table->string('fuelType')->nullable();
            $table->string('channel')->nullable();
            $table->string('applicationVContractDuration')->nullable();
            $table->string('serviceLevelPayment')->nullable();
            $table->string('serviceLevelInvoicing')->nullable();
            $table->string('serviceLevelContact')->nullable();
            $table->string('minimumSupplyCondition')->nullable();
            $table->integer('duration')->nullable();
            $table->string('applicability')->nullable();
            $table->string('valueType')->nullable();
            $table->float('value', 8,3)->nullable();
            $table->string('unit')->nullable();
            $table->string('applicableForExistingCustomers')->nullable();
            $table->string('greylist')->nullable();
            $table->string('productId')->nullable();
            $table->string('nameNl')->nullable();
            $table->string('descriptionNl',5000)->nullable();
            $table->string('nameFr')->nullable();
            $table->string('descriptionFr',5000)->nullable();
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
        Schema::dropIfExists('discounts');
    }
}
