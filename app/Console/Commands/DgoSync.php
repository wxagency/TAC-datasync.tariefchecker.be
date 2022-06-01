<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Dgo;
use Carbon\Carbon;
use Session;
use DateTime;

class DgoSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dgo:sync';

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
            $this->alert('Fetching DGO from Airtable : ' . Carbon::now());
            $this->_syncDGO();
            $this->comment('Completed at : ' . Carbon::now());
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function _syncDGO()
    {
        Dgo::truncate();
        Session::put('offset', '0');
        while (Session::get('offset') != 'stop') {
            try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] = 100;
                $query['offset'] = Session::get('offset');
                $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/DGO', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                    ],
                    'query' => $query
                ]);
            } catch (Exception $ex) {
                return $ex->getCode();
            }
            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);

            if (isset($json['offset'])) {
                Session::put('offset', $json['offset']);
            } else {

                Session::put('offset', 'stop');
            }
            foreach ($json['records'] as $dgo) {
                if (!empty($dgo['fields']['DGO'])) {
                    if (isset($dgo['id'])) {
                        $recordId = $dgo['id'];
                    } else {
                        $recordId = NULL;
                    }

                    if (isset($dgo['fields']['DGO'])) {
                        $dnb = $dgo['fields']['DGO'];
                    } else {
                        $dnb = NULL;
                    }
                    Dgo::create(
                        [
                            '_id' => $recordId,
                            'dgo' => $dnb,
                        ]
                    );
                    $update = Carbon::now();
                    Session::put('update', $update);
                }
            }
        }
        $this->info('All dgo are saved');
    }
}
