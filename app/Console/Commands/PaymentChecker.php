<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Orders;
use App\Helpers\Fawry;
class PaymentChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PaymentChecker:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaymentChecker';

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
        $orders = Orders::where(['status'=>1,'paymeny'=>'New'])->limit(100)->get();
        foreach ($orders as $order) {
            $item  =  ($order->type == 1)?$order->request:$order->application;
            $fawry = new Fawry();
            $result = $fawry->checkPaymentStatus($item);
            if($result->status){
                $falier = 0;
                if ($result->data->paymentStatus=="NEW") {
                    $status = 1;
                }elseif ($result->data->paymentStatus=="PAID") {
                    $status = 2;
                }else{
                    $status = 1;
                    $falier = 2;
                }
                $status = ($result->data->paymentStatus=="PAID"&&$result->data->paymentStatus=!"NEW")?2:1;
                $dataToStore = ['status'=>$status,'falier'=>$falier,'paymeny'=>$result->data->paymentStatus,'payment_method'=>$result->data->paymentMethod];
                Orders::find($order->id)->update($dataToStore);
                $noti = new \App\Http\Controllers\NotificationController();
                $noti->serviceRequest($order);
            }
        }
     
    }
}
