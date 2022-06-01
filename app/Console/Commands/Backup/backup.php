<?php

namespace App\Console\Commands\Backup;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use App\Models\History\BackupDate;

class backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:start';

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
      $backup = Carbon::now(); 
       $this->info('Backup Started on '. $backup);
     
        Session::put('backup-date',$backup);
        
        $this->call('staticdata:backup');
        $this->call('DynamicData:backup');
        $this->call('DiscountHistory:backup');
        $this->call('Postalcode:backup');

        BackupDate::create ([
            'backupdate' => Session::get('backup-date')
            ]);
        Session::forget('backup-date');
        $this->info('Backup completed');
    }
}
