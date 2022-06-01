<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::connection('mysql2')->create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('backupdate');
            $table->integer('supplier_id')->nullable();
            $table->string('suppliertype')->nullable();
            $table->string('origin')->nullable();
            $table->string('official_name')->nullable();
            $table->string('commercial_name')->nullable();
            $table->string('abbreviation')->nullable();
            $table->string('parent_company')->nullable();
            $table->string('logo_large')->nullable();
            $table->string('logo_small')->nullable();
            $table->string('website')->nullable();
            $table->string('youtube_video')->nullable();
            $table->string('video_webm')->nullable();
            $table->string('B2b_customers')->nullable();
            $table->string('B2c_customers')->nullable();
            $table->integer('greenpeace_rating')->nullable();
            $table->integer('Vreg_rating')->nullable();
            $table->integer('customer_rating')->nullable();
            $table->integer('advice_rating')->nullable();
            $table->string('presentation', 1000)->nullable();
            $table->text('mission_vision')->nullable();
            $table->string('supplier_values', 1000)->nullable();
            $table->text('services')->nullable();
            $table->string('mission_vision_image', 600)->nullable();
            $table->string('facebook_page', 800)->nullable();
            $table->string('twitter_name')->nullable();
            $table->string('location')->nullable();
            $table->string('video_mp4')->nullable();
            $table->string('video_ogg')->nullable();
            $table->string('video_flv')->nullable();
            $table->string('greenpeace_report', 1000)->nullable();
            $table->string('greenpeace_report_url', 300)->nullable();
            $table->string('greenpeace_supplier_response',1000)->nullable();
            $table->string('greenpeace_production_image')->nullable();
            $table->string('greenpeace_investments_image')->nullable();
            $table->string('greenpeace_report_pdf', 300)->nullable();
            $table->string('tagline')->nullable();
            $table->string('vimeo_url')->nullable();
            $table->string('is_partner')->nullable();
            $table->string('customer_reviews', 400)->nullable();
            $table->string('logo_medium')->nullable();
            $table->string('conversion_value', 400)->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
