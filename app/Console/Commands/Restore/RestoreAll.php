<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\BackupDate;

class RestoreAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restore:all';

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
        $activeRestore = BackupDate::where('status' , 1)->first();
        if ($activeRestore){

            if($activeRestore->counter == 1 ) {

                $this->call('supplier:update');
                $activeRestore->counter = 2;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 2 ) {
                $this->call('elek-res:update');
                $activeRestore->counter = 3;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 3 ) {
                $this->call('elek-pro:update');
                $activeRestore->counter = 4;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 4 ) {
                $this->call('gas-res:update');
                $activeRestore->counter = 5;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 5 ) {
                $this->call('gas-pro:update');
                $activeRestore->counter = 6;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 6 ) {
                $this->call('pack-res:update');
                $activeRestore->counter = 7;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 7 ) {
                $this->call('pack-pro:update');
                $activeRestore->counter = 8;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 8 ) {
                $this->call('dynamic-elekRes:update');
                $activeRestore->counter = 9;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 9 ) {
                $this->call('dynamic-elekPro:update');
                $activeRestore->counter = 10;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 10 ) {
                $this->call('dynamic-gasPro:update');
                $activeRestore->counter = 11;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 11 ) {
                $this->call('dynamic-gasRes:update');
                $activeRestore->counter = 12;
                $activeRestore->save();
            }
            
            if ($activeRestore->counter == 12 ) {
                $this->call('tax-E:update');
                $activeRestore->counter = 13;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 13 ) {
                $this->call('tax-G:update');
                $activeRestore->counter = 14;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 14 ) {
                $this->call('netcost-E:update');
                $activeRestore->counter = 15;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 15 ) {
                $this->call('netcost-G:update');
                $activeRestore->counter = 16;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 16 ) {
                $this->call('discount-data:update');
                $activeRestore->counter = 17;
                $activeRestore->save();

            }
            if ($activeRestore->counter == 17 ) {
                // $this->call('postalcode-electricity:update');
                $activeRestore->counter = 18;
                $activeRestore->save();
            }
            if ($activeRestore->counter == 18 ) {
                // $this->call('postalcode-gas:update');
                $activeRestore->status = 0;
                $activeRestore->save();
            }
        }
    }
}
