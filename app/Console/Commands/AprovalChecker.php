<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Orders;
use App\Helpers\Fawry;
class AprovalChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AprovalChecker:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AprovalChecker';

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
        $before1day = Carbon::now()->subDay(1)->format('Y-m-d');
        $orders = Orders::where([['status',0],['type',1],['falier',0],['created_at',$before1day]])->limit(100)->get();
        foreach ($orders as $order) {
            $noti = new \App\Http\Controllers\NotificationController();
            $noti->requestNoAction($order);
            Orders::where('id',$order->id)->update(['falier'=>6]);
        }      
    }
}
