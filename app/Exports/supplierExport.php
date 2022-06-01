<?php 
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use App\Models\History\Supplier;
use Session;

class supplierExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    public function collection()
    {
        return Supplier::where('backupdate', Session::get('backupdate'))->get();
    }

    public function headings(): array
    {
        return [
            'id',
            '_id',
            'backupdate',
            'supplier_id',
            'suppliertype',
            'origin',
            'official_name',
            'commercial_name',
            'abbreviation',
            'parent_company',
            'logo_large',
            'logo_small',
            'website',
            'youtube_video',
            'video_webm',
            'B2b_customers',
            'B2c_customers',
            'greenpeace_rating',
            'Vreg_rating',
            'customer_rating',
            'advice_rating',
            'presentation',
            'mission_vision',
            'supplier_values',
            'services',
            'mission_vision_image',
            'facebook_page',
            'twitter_name',
            'location',
            'video_mp4',
            'video_ogg',
            'video_flv',
            'greenpeace_report',
            'greenpeace_report_url',
            'greenpeace_supplier_response',
            'greenpeace_production_image',
            'greenpeace_investments_image',
            'greenpeace_report_pdf',
            'tagline',
            'vimeo_url',
            'is_partner',
            'customer_reviews',
            'logo_medium',
            'conversion_value',
            'created_at',
            'updated_at',
        ];
    }

}