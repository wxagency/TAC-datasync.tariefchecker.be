<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TaxElectricity;
use App\Models\TaxGas;
use Carbon\Carbon;
use Session;

class ManageTax extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tax:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->alert('Fetching taxes from Airtable : ' . Carbon::now());
            $this->_electricityTax();
            $this->_gasTax();
            $this->comment('Completed at : ' . Carbon::now());
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function _electricityTax()
    {
        TaxElectricity::truncate();

        Session::put('offset', '0');
        while (Session::get('offset') != 'stop') {
            try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] = 100;
                $query['offset'] = Session::get('offset');
                $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Tax%20-%20E', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                    ],
                    'query' => $query
                ]);
            } catch (Exception $e) {
                return $e->getCode();
            }
            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);
            if (isset($json['offset'])) {
                Session::put('offset', $json['offset']);
            } else {

                Session::put('offset', 'stop');
            }
            foreach ($json['records'] as $electricityTax) {
                if (!empty($electricityTax['fields']['Date'])) {
                    if (isset($electricityTax['id'])) {
                        $recordId = $electricityTax['id'];
                    } else {
                        $recordId = NULL;
                    }
                    if (isset($electricityTax['fields']['Date'])) {
                        $date = $electricityTax['fields']['Date'];
                    } else {
                        $date = NULL;
                    }
                    if (isset($electricityTax['fields']['Valid from'])) {
                        $validFrom = $electricityTax['fields']['Valid from'];
                    } else {
                        $validFrom = NULL;
                    }
                    if (isset($electricityTax['fields']['Valid till'])) {
                        $validTill = $electricityTax['fields']['Valid till'];
                    } else {
                        $validTill = NULL;
                    }
                    if (isset($electricityTax['fields']['DGO'])) {
                        $dnb = $electricityTax['fields']['DGO'];
                        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Tax%20-%20E/' . $dnb[0], [
                            'headers' => [
                                'Accept' => 'application/json',
                                'Content-type' => 'application/json',
                                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                            ]

                        ]);

                        $response = $request->getBody()->getContents();
                        $json = json_decode($response, true);
                        $dgo = $json['fields']['DGO'];
                    } else {
                        $dnb = NULL;
                    }
                    if (isset($electricityTax['fields']['DGO - Electrabel name'])) {
                        $electrabelbenaming = $electricityTax['fields']['DGO - Electrabel name'];
                    } else {
                        $electrabelbenaming = NULL;
                    }
                    if (isset($electricityTax['fields']['Fuel'])) {
                        $fuel = $electricityTax['fields']['Fuel'];
                    } else {
                        $fuel = NULL;
                    }
                    if (isset($electricityTax['fields']['Customer Segment'])) {
                        $segment = $electricityTax['fields']['Customer Segment'];
                    } else {
                        $segment = NULL;
                    }
                    if (isset($electricityTax['fields']['VL'])) {
                        $vl = $electricityTax['fields']['VL'];
                    } else {
                        $vl = NULL;
                    }
                    if (isset($electricityTax['fields']['WA'])) {
                        $wa = $electricityTax['fields']['WA'];
                    } else {
                        $wa = NULL;
                    }
                    if (isset($electricityTax['fields']['BR'])) {
                        $br = $electricityTax['fields']['BR'];
                    } else {
                        $br = NULL;
                    }
                    if (isset($electricityTax['fields']['Volume lower'])) {
                        $volumeLower = $electricityTax['fields']['Volume lower'];
                    } else {
                        $volumeLower = NULL;
                    }
                    if (isset($electricityTax['fields']['Volume upper'])) {
                        $volumeUpper = $electricityTax['fields']['Volume upper'];
                    } else {
                        $volumeUpper = NULL;
                    }
                    if (isset($electricityTax['fields']['Energy contribution'])) {
                        $energyContribution = $electricityTax['fields']['Energy contribution'];
                        $energyContribut = str_replace(",", ".", $energyContribution);
                        $energyContribution = preg_replace('/\.(?=.*\.)/', '', $energyContribut);
                    } else {
                        $energyContribution = NULL;
                    }
                    if (isset($electricityTax['fields']['Federal contribution'])) {
                        $federalContribution = $electricityTax['fields']['Federal contribution'];
                        $federalContribut = str_replace(",", ".", $federalContribution);
                        $federalContribution = preg_replace('/\.(?=.*\.)/', '', $federalContribut);
                    } else {
                        $federalContribution = NULL;
                    }
                    if (isset($electricityTax['fields']['Connection fee'])) {
                        $connectionfee = $electricityTax['fields']['Connection fee'];
                        $connectionf = str_replace(",", ".", $connectionfee);
                        $connectionfee = preg_replace('/\.(?=.*\.)/', '', $connectionf);
                    } else {
                        $connectionfee = NULL;
                    }
                    if (isset($electricityTax['fields']['Contribution public services'])) {
                        $publicServices = $electricityTax['fields']['Contribution public services'];
                        $publicServ = str_replace(",", ".", $publicServices);
                        $publicServices = preg_replace('/\.(?=.*\.)/', '', $publicServ);
                    } else {
                        $publicServices = NULL;
                    }
                    if (isset($electricityTax['fields']['fixed taks_first res'])) {
                        $fixedtaxFirst = $electricityTax['fields']['fixed taks_first res'];
                        $fixedtaxFir = str_replace(",", ".", $fixedtaxFirst);
                        $fixedtaxFirst = preg_replace('/\.(?=.*\.)/', '', $fixedtaxFir);
                    } else {
                        $fixedtaxFirst = NULL;
                    }
                    if (isset($electricityTax['fields']['fixed taks_not first residence'])) {
                        $fixedtaxNotFirst = $electricityTax['fields']['fixed taks_not first residence'];
                        $fixedtaxNot = str_replace(",", ".", $fixedtaxNotFirst);
                        $fixedtaxNotFirst = preg_replace('/\.(?=.*\.)/', '', $fixedtaxNot);
                    } else {
                        $fixedtaxNotFirst = NULL;
                    }
                    $newdate =$date; // Carbon::createFromFormat('d/m/Y', $date)->toDateString();
                    $newValidFrom =$validFrom; // Carbon::createFromFormat('d/m/Y', $validFrom)->toDateString();
                    $newValidtill =$validTill; // Carbon::createFromFormat('d/m/Y', $validTill)->toDateString();
                    TaxElectricity::create(
                        [
                            '_id' => $recordId,
                            'date' => $newdate,
                            'valid_from' => $newValidFrom,
                            'valid_till' => $newValidtill,
                            'dgo' => $dgo,
                            'dgo_electrabelname' => $electrabelbenaming,
                            'fuel' => $fuel,
                            'segment' => $segment,
                            'VL' => $vl,
                            'WA' => $wa,
                            'BR' => $br,
                            'volume_lower' => $volumeLower,
                            'volume_upper' => $volumeUpper,
                            'energy_contribution' => $energyContribution,
                            'federal_contribution' => $federalContribution,
                            'connection_fee' => $connectionfee,
                            'contribution_public_services' => $publicServices,
                            'fixed_tax_first_res' => $fixedtaxFirst,
                            'fixed_tax_not_first_res' => $fixedtaxNotFirst,
                        ]
                    );
                }
            }
        }
        $this->info('Products saved from taxes Electricity');
    }

    private function _gasTax()
    {
        TaxGas::truncate();
        Session::put('offset', '0');
        while (Session::get('offset') != 'stop') {
            try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] = 100;
                $query['offset'] = Session::get('offset');
                $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Tax%20-%20G', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                    ],
                    'query' => $query
                ]);
            } catch (Exception $e) {
                return $e->getCode();
            }
            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);
            if (isset($json['offset'])) {
                Session::put('offset', $json['offset']);
            } else {

                Session::put('offset', 'stop');
            }
            foreach ($json['records'] as $gasTax) {
                if (!empty($gasTax['fields']['Date'])) {
                    if (isset($gasTax['id'])) {
                        $recordId = $gasTax['id'];
                    } else {
                        $recordId = NULL;
                    }
                    if (isset($gasTax['fields']['Date'])) {
                        $date = $gasTax['fields']['Date'];
                    } else {
                        $date = NULL;
                    }
                    if (isset($gasTax['fields']['Valid from'])) {
                        $validFrom = $gasTax['fields']['Valid from'];
                    } else {
                        $validFrom = NULL;
                    }
                    if (isset($gasTax['fields']['Valid till'])) {
                        $validTill = $gasTax['fields']['Valid till'];
                    } else {
                        $validTill = NULL;
                    }
                    if (isset($gasTax['fields']['DGO'])) {
                        $dnb = $gasTax['fields']['DGO'];
                        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Tax%20-%20G/' . $dnb[0], [
                            'headers' => [
                                'Accept' => 'application/json',
                                'Content-type' => 'application/json',
                                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                            ]

                        ]);

                        $response = $request->getBody()->getContents();
                        $json = json_decode($response, true);
                        $dgo = $json['fields']['DGO'];
                    } else {
                        $dnb = NULL;
                    }
                    if (isset($gasTax['fields']['DGO - Electrabel name'])) {
                        $electrabelbenaming = $gasTax['fields']['DGO - Electrabel name'];
                    } else {
                        $electrabelbenaming = NULL;
                    }
                    if (isset($gasTax['fields']['Fuel'])) {
                        $fuel = $gasTax['fields']['Fuel'];
                    } else {
                        $fuel = NULL;
                    }
                    if (isset($gasTax['fields']['Customer Segment'])) {
                        $segment = $gasTax['fields']['Customer Segment'];
                    } else {
                        $segment = NULL;
                    }
                    if (isset($gasTax['fields']['VL'])) {
                        $vl = $gasTax['fields']['VL'];
                    } else {
                        $vl = NULL;
                    }
                    if (isset($gasTax['fields']['WA'])) {
                        $wa = $gasTax['fields']['WA'];
                    } else {
                        $wa = NULL;
                    }
                    if (isset($gasTax['fields']['BR'])) {
                        $br = $gasTax['fields']['BR'];
                    } else {
                        $br = NULL;
                    }
                    if (isset($gasTax['fields']['Volume lower'])) {
                        $volumeLower = $gasTax['fields']['Volume lower'];
                    } else {
                        $volumeLower = NULL;
                    }
                    if (isset($gasTax['fields']['Volume upper'])) {
                        $volumeUpper = $gasTax['fields']['Volume upper'];
                    } else {
                        $volumeUpper = NULL;
                    }
                    if (isset($gasTax['fields']['Energy contribution'])) {
                        $energyContribution = $gasTax['fields']['Energy contribution'];
                        $energyContribut = str_replace(",", ".", $energyContribution);
                        $energyContribution = preg_replace('/\.(?=.*\.)/', '', $energyContribut);
                    } else {
                        $energyContribution = NULL;
                    }
                    if (isset($gasTax['fields']['Federal contribution'])) {
                        $federalContribution = $gasTax['fields']['Federal contribution'];
                        $federalContribut = str_replace(",", ".", $federalContribution);
                        $federalContribution = preg_replace('/\.(?=.*\.)/', '', $federalContribut);
                    } else {
                        $federalContribution = NULL;
                    }
                    if (isset($gasTax['fields']['Contribution protected customers'])) {
                        $protectedCustomers = $gasTax['fields']['Contribution protected customers'];
                        $protectedCustomer = str_replace(",", ".", $protectedCustomers);
                        $protectedCustomers = preg_replace('/\.(?=.*\.)/', '', $protectedCustomer);
                    } else {
                        $protectedCustomers = NULL;
                    }
                    if (isset($gasTax['fields']['Connection fee'])) {
                        $connectionfee = $gasTax['fields']['Connection fee'];
                        $connection = str_replace(",", ".", $connectionfee);
                        $connectionfee = preg_replace('/\.(?=.*\.)/', '', $connection);
                    } else {
                        $connectionfee = NULL;
                    }
                    if (isset($gasTax['fields']['Contribution public services'])) {
                        $publicServices = $gasTax['fields']['Contribution public services'];
                        $publicService = str_replace(",", ".", $publicServices);
                        $publicServices = preg_replace('/\.(?=.*\.)/', '', $publicService);
                    } else {
                        $publicServices = NULL;
                    }
                    if (isset($gasTax['fields']['fixed tax'])) {
                        $fixedtax = $gasTax['fields']['fixed tax'];
                        $fixedt = str_replace(",", ".", $fixedtax);
                        $fixedtax = preg_replace('/\.(?=.*\.)/', '', $fixedt);
                    } else {
                        $fixedtax = NULL;
                    }
                    $newdate =$date; // Carbon::createFromFormat('d/m/Y', $date)->toDateString();
                    $newValidFrom =$validFrom; // Carbon::createFromFormat('d/m/Y', $validFrom)->toDateString();
                    $newValidtill =$validTill; // Carbon::createFromFormat('d/m/Y', $validTill)->toDateString();
                    TaxGas::create(
                        [
                            '_id' => $recordId,
                            'date' => $newdate,
                            'valid_from' => $newValidFrom,
                            'valid_till' => $newValidtill,
                            'dgo' => $dgo,
                            'dgo_electrabelname' => $electrabelbenaming,
                            'fuel' => $fuel,
                            'segment' => $segment,
                            'VL' => $vl,
                            'WA' => $wa,
                            'BR' => $br,
                            'volume_lower' => $volumeLower,
                            'volume_upper' => $volumeUpper,
                            'energy_contribution' => $energyContribution,
                            'federal_contribution' => $federalContribution,
                            'contribution_protected_customers' => $protectedCustomers,
                            'connection_fee' => $connectionfee,
                            'contribution_public_services' => $publicServices,
                            'fixed_tax' => $fixedtax,
                        ]
                    );
                }
            }
        }
        $this->info('Products saved from taxes Gas');
    }
}
