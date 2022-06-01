<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\Discount as DIS;

use App\Models\History\Discount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DateTime;

class DiscountHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DiscountHistory:backup';

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
            $this->_discount();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function _discount()
    {
        $discount = DIS::all();
        if (Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup', $backup);
        }

        foreach ($discount as $disc) {
            Discount::Create(
                [
                    '_id' =>  $disc->_id,
                    'backupdate' => $backup,
                    'discountId' => $disc->discountId,
                    'supplier' => $disc->supplier,
                    'discountCreated' => $disc->discountCreated,
                    'startdate' => $disc->startdate,
                    'enddate' => $disc->enddate,
                    'customergroup' => $disc->customergroup,
                    'volume_lower' => $disc->volume_lower,
                    'volume_upper' => $disc->volume_upper,
                    'discountType' => $disc->discountType,
                    'fuelType' => $disc->fuelType,
                    'channel' => $disc->channel,
                    'applicationVContractDuration' => $disc->applicationVContractDuration,
                    'serviceLevelPayment' => $disc->serviceLevelPayment,
                    'serviceLevelInvoicing' => $disc->serviceLevelInvoicing,
                    'serviceLevelContact' => $disc->serviceLevelContact,
                    'minimumSupplyCondition' => $disc->minimumSupplyCondition,
                    'duration' => $disc->duration,
                    'applicability' => $disc->applicability,
                    'valueType' => $disc->valueType,
                    'value' => $disc->value,
                    'unit' => $disc->unit,
                    'applicableForExistingCustomers' => $disc->applicableForExistingCustomers,
                    'greylist' => $disc->greylist,
                    'productId' => $disc->productId,
                    'nameNl' => $disc->nameNl,
                    'descriptionNl' => $disc->descriptionNl,
                    'nameFr' => $disc->nameFr,
                    'descriptionFr' => $disc->descriptionFr,
                ]
            );
        }
        $this->info('Discount Back up completed');
    }
}
