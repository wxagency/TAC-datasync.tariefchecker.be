<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class PostalcodeGas extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'postalcode_dgo_gases';

    protected $fillable = [
        '_id',
        'backupdate',
        'distribution_id', 
        'netadmin_zip', 
        'netadmin_city', 
        'netadmin_subcity', 
        'product', 
        'grid_operational', 
        'gas_H_L',
        'DNB',
        'netadmin_website',
        'TNB',
        'language_code',
        'region',       
        'created_at',
        'updated_at',
 
    ];
}
