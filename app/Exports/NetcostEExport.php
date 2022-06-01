<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\History\Netcostes;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Session;

class NetcostEExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Netcostes::where('backupdate', Session::get('backupdate'))->get();
    }
    public function headings(): array
    {
        return [
            'id',
            '_id',
            'backupdate',
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
            'reading_meter	',
            'prosumers',
            'transport',
            'created_at',
            'updated_at',
        ];
    }
}
