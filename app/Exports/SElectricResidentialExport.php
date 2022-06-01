<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\History\StaticElecticResidential;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Session;

class SElectricResidentialExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StaticElecticResidential::where('backup_date', Session::get('backupdate'))->get();
    }

    public function headings(): array
    {
        return [
            'id',
            '_id',
            'backupdate',
            'product_id',
            'acticve',
            'partner',
            'supplier',
            'product_name_NL',
            'product_name_FR',
            'fuel',
            'duration',
            'fixed_indiable',
            'green_percentage',
            'origin',
            'segment',
            'VL',
            'WA',
            'BR',
            'service_level_payment',
            'service_level_invoicing',
            'service_level_contact',
            'FF_pro_rata',
            'inv_period',
            'customer_condition',
            'subscribe_url_NL',
            'info_NL',
            'tariff_description_NL',
            'terms_NL',
            'subscribe_url_FR',
            'info_FR',
            'tariff_description_FR',
            'terms_FR',
            'created_at',
            'updated_at',
        ];
    }
}
