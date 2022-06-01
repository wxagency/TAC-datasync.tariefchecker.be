<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class DynamicGasResidential extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'dynamic_gas_residentials';

    protected $fillable = ['_id','backupdate', 'product_id', 'date', 'valid_from', 'valid_till', 'supplier','product',
    'fuel','duration', 'fixed_indexed', 'segment', 'VL', 'WA', 'BR', 'volume_lower', 'volume_upper',
    'price_gas', 'ff', 'prices_url_nl', 'prices_url_fr', 'index_name', 'index_value', 'coeff', 'term'
    ];
}
