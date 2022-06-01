<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackupDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backup_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('backupdate');
            $table->boolean('status')->default(0);
            $table->integer('counter')->nullable();
            $table->datetime('last_restored')->nullable();
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
        Schema::dropIfExists('backup_dates');
    }
}
