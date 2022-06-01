<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\History\PostalcodeElectricity;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Session;

class PostCodeElectricityExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PostalcodeElectricity::where('backupdate', Session::get('backupdate'))->get();
    }

    public function headings(): array
    {
        return [
            'id',
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
}
