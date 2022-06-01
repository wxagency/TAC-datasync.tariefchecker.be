<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class StaticPackProfessional extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'static_pack_professionals';

    protected $fillable = [
        '_id',
        'pack_id', 
        'backupdate',
        'pack_name_NL', 
        'pack_name_FR', 
        'active', 
        'partner', 
        'pro_id_E',
        'pro_id_G',
        'URL_NL',
        'info_NL',
        'tariff_description_NL',
        'URL_FR',
        'info_FR',
        'tariff_description_FR',
        'check_elec',
        'check_gas',      
        'created_at',
        'updated_at',
 
    ];
}
