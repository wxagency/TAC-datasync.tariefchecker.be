<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSearchHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_search_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable()->unique();
            $table->tinyInteger('residential_professional')->comment('0: Residential; 1: Professional')->nullable();
            $table->string('postalcode')->nullable();
            $table->integer('familysize')->nullable();
            $table->integer('single')->nullable();
            $table->integer('day')->nullable();
            $table->integer('night')->nullable();
            $table->integer('excl_night')->nullable();
            $table->string('current_electric_supplier')->nullable();
            $table->integer('gas_consumption')->nullable();
            $table->string('current_gas_supplier')->nullable();
            $table->string('email', 100)->nullable()->unique();
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
        Schema::dropIfExists('user_search_histories');
    }
}
