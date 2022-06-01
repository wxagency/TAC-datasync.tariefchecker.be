<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\Netcostgs as NCG;

use App\Models\History\Netcostes;
use App\Models\History\Netcostgs;
use Carbon\Carbon;
use Session;
use DateTime;

class NetcostBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Netcost:backup';

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
            $this->call('ENetcost:backup');
            $this->call('GNetcost:backup');
            $this->info('Netcost back up completed');
        } catch (\exception $e) {
            return $e->getMessage();
        }
    }
}
