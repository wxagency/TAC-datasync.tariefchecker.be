<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\History\StaticPackProfessional;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Session;

class PackProfessionExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StaticPackProfessional::where('backupdate', Session::get('backupdate'))->get();
    }

    public function headings(): array
    {
        return [
            'id',
            '_id',
            'backupdate',
            'pack_id',
            'pack_name_NL',
            'pack_name_FR',
            'active',
            'partner',
            'pro_id_E',
            'pro_id_G',
            'URL_NL',
            'info_NL',
            'tariff_description_NL',
            'URL_FR',
            'info_FR',
            'tariff_description_FR',
            'check_elec',
            'check_gas',
            'created_at',
            'updated_at',
        ];
    }
}
