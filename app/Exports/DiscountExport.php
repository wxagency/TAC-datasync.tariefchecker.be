<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use App\Models\History\Discount;
use Session;

class DiscountExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Discount::where('backupdate', Session::get('backupdate'))->get();
    }

    public function headings(): array
    {
        return [
            'id',
            '_id',
            'backupdate',
            'discountId',
            'supplier',
            'discountCreated',
            'startdate',
            'enddate',
            'customergroup',
            'volume_lower',
            'volume_upper',
            'discountType',
            'fuelType',
            'comparisonType',
            'channel',
            'applicationVContractDuration',
            'serviceLevelPayment',
            'serviceLevelInvoicing',
            'serviceLevelContact',
            'discountcodeE' ,
            'discountcodeG',
            'discountcodeP',
            'minimumSupplyCondition',
            'duration',
            'applicability',
            'valueType',
            'value',
            'unit',
            'applicableForExistingCustomers',
            'greylist',
            'productId',
            'nameNl',
            'descriptionNl',
            'nameFr',
            'descriptionFr',
            'created_at',
            'updated_at',
        ];
    }

}
