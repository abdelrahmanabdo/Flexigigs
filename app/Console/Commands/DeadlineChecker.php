<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Orders;
use App\Helpers\Fawry;
class DeadlineChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeadlineChecker:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DeadlineChecker';

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
        $current = Carbon::now();//->toDateTimeString();
        //24 hour without acceptance
        
        // -2 days
        $orders = Orders::where([['status',2],['deadline_notifi',0],['delivery_at',$current->addDay(2)->format('Y-m-d')]])->limit(100)->get();
        $current = Carbon::now();
        foreach ($orders as $order) {
            $delivery_at=date_create($order->delivery_at);
            $created_at=date_create($order->created_at);
            $diff=date_diff($delivery_at,$current);
            // var_dump($diff);
            
            if ($diff->days>=1) {
                 // var_dump('fadel youmain');
                 // var_dump($order->id);
                $noti = new \App\Http\Controllers\NotificationController();
                $noti->beforedeadline($order);
            }
            Orders::where('id',$order->id)->update(['deadline_notifi'=>1]);
        }   
        // in days
        $orders = Orders::where([['status',2],['deadline_notifi',1],['delivery_at','=',date('Y-m-d')]])->limit(100)->get();
        foreach ($orders as $order) {
            // var_dump('anhrda L deadline');
            // var_dump($order->id);
            $noti = new \App\Http\Controllers\NotificationController();
            $noti->deadlineday($order);
            Orders::where('id',$order->id)->update(['deadline_notifi'=>2]);
        }
       // after 2 days +2 days
        $after2days =Carbon::now()->subDay(2)->format('Y-m-d');
        $orders = Orders::where([['status',2],['deadline_notifi',2],['delivery_at',$after2days]])->limit(100)->get();
        foreach ($orders as $order) {
            // var_dump('3da youmain 3la l deadline');
            // var_dump($order->id);
            $noti = new \App\Http\Controllers\NotificationController();
            $noti->afterdeadline2days($order);
            Orders::where('id',$order->id)->update(['deadline_notifi'=>3]);
        }
       // after 4 days +4 days
        $after4days = Carbon::now()->subDay(4)->format('Y-m-d');
        $orders = Orders::where([['status',2],['deadline_notifi',5],['delivery_at',$after4days]])->limit(100)->get();
        foreach ($orders as $order) {
            // var_dump('3da 4 ayam 3la l deadline');
            // var_dump($order->id);
            $noti = new \App\Http\Controllers\NotificationController();
            $noti->afterdeadline4days($order);
            Orders::where('id',$order->id)->update(['deadline_notifi'=>4]);
        }        
    }
    
}
