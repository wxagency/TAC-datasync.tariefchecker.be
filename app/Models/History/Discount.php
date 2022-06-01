<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'discounts';
    
    protected $fillable = ['_id','backupdate','discountId', 'supplier', 'discountCreated', 'startdate', 'enddate','customergroup',
    'volume_lower','volume_upper', 'discountType', 'fuelType', 'comparisonType', 'channel', 'applicationVContractDuration',
    'serviceLevelPayment', 'serviceLevelInvoicing','serviceLevelContact','discountcodeE' ,'discountcodeG','discountcodeP', 'minimumSupplyCondition', 'duration', 
    'applicability','valueType', 'value', 'unit', 'applicableForExistingCustomers', 'greylist', 'productId', 
    'nameNl','descriptionNl', 'nameFr', 'descriptionFr'
    ];
}
