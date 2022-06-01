<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\History\Netcostgs;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Session;

class NetcostGExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Netcostgs::where('backupdate', Session::get('backupdate'))->get();
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
            'fixed_term',
            'variable_term',
            'reading_meter_yearly',
            'reading_meter_monthly',
            'transport',
            'created_at',
            'updated_at',
        ];
    }
}
