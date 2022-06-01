<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class StaticElectricProfessional extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'static_elec_professionals';

    protected $fillable = [
        '_id',
        'product_id', 
        'backupdate',
        'acticve', 
        'partner', 
        'supplier', 
        'product_name_NL', 
        'product_name_FR',
        'fuel',
        'duration',
        'fixed_indiable',
        'green_percentage',
        'origin',
        'segment',
        'VL',
        'WA',
        'BR',
        'service_level_payment',
        'service_level_invoicing',
        'service_level_contact',
        'FF_pro_rata',
        'inv_period',
        'customer_condition',
        'subscribe_url_NL',
        'info_NL',
        'tariff_description_NL',
        'terms_NL',
        'subscribe_url_FR',
        'info_FR',
        'tariff_description_FR',
        'terms_FR',
        'created_at',
        'updated_at',
 
    ];
}
