<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Netcostes extends Model
{
    protected $table = 'netcoste';

    protected $fillable = [
        '_id',
        'date', 
        'valid_from', 
        'valid_till', 
        'dgo', 
        'dgo_electrabelname', 
        'fuel', 
        'segment',
        'VL',
        'WA',
        'BR',
        'volume_lower',
        'volume_upper',       
        'price_single',
        'price_day',
        'price_night',
        'price_excl_night',
        'reading_meter',
        'prosumers',
        'transport',
        'created_at',
        'updated_at',
 
    ];


}
