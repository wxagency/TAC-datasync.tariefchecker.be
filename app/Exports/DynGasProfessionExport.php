<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\History\DynamicGasProfessional;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Session;

class DynGasProfessionExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DynamicGasProfessional::where('backupdate', Session::get('backupdate'))->get();
    }

    public function headings(): array
    {
        return [
            'id',
            '_id',
            'backupdate',
            'product_id',
            'date',
            'valid_from',
            'valid_till',
            'supplier',
            'product',
            'fuel',
            'duration',
            'fixed_indexed',
            'segment',
            'VL',
            'WA',
            'BR',
            'volume_lower',
            'volume_upper',
            'price_gas',
            'ff',
            'prices_url_nl',
            'prices_url_fr',
            'index_name',
            'index_value',
            'coeff',
            'term',
            'created_at',
            'updated_at',
        ];
    }
}
