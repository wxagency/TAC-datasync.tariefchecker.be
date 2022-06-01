<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\History\TaxGas;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Session;

class TaxGExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TaxGas::where('backupdate', Session::get('backupdate'))->get();
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
            'energy_contribution',
            'federal_contribution',
            'contribution_protected_customers',
            'connection_fee',
            'contribution_public_services',
            'fixed_tax',
            'created_at',
            'updated_at',
        ];
    }
}
