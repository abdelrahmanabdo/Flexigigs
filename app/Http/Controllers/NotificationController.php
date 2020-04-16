<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\Gigs;
use App\Applications;
use Auth;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use App\Helpers\Flexihelp;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Bogardo\Mailgun\Facades\Mailgun;
use FCM;
/**
 * Description of NotificationController
 *
 * @author Ramy
 */
class NotificationController extends Controller {
    
    public $From='TheFlexiTeam';
    public $FromEmail='admin@flexigigs.me';
    public $ToEmails='';
    public $ToBcc='';
    public $Subject='';
    public $Subject_ar='';
    public $Lang='en';
    public $Template='';
    public $SMSTo='';
    public $SMSMessage='';
    public function __construct() {
        
    }
    public function contactUs($data)
    {
        $Data['data'] = $data;
        $this->ToEmails=$this->FromEmail;
        $this->ToBcc = "mibrahim@road9media.com";
        $this->FromEmails="admin@flexigigs.me";
        $this->Subject=$data['subject'];
        $this->Template='ContactUs';
        $this->SendMail($Data);        
    }
    public function SendNewService($user=null,$service=null)
    {
        if ($user&&$service) {
            $Data['service'] = $service;
            $Data['username'] = $user->username;
            $this->ToEmails=$user->email;
            $this->Subject='New Service Submitted';
            $this->Subject_ar='خدمة جديدة مقدّمة';
            $this->Lang=$user->lang_perfix;
            $this->Template='NewService';
            $this->SendMail($Data);
        }
    }
    public function forgetpassword($user=null,$token=null){
        if ($user&&$token) {
            $Data['token'] = $token;
            $Data['user'] = $user;
            $this->ToEmails = $user->email;
            $this->Subject='Flexigigs account password reset';
            $this->Subject_ar='نسيت كلمة المرور';
            $this->Lang=$user->lang_perfix;
            $this->Template='forgetpassword';
            $this->SendMail($Data);
        }
    }

    public function sendFollowersGig($user , $gig){
        $Data['username']=$user->username;
        $Data['gig']=$gig;

        $this->ToEmails=$user->email;
        $this->Subject='A New Gig Matches Your Skills!';
        $this->Subject_ar='وظيفة جديدة مقدّمة';
        $this->Lang=$user->lang_perfix;
        $this->Template='NewGig';
        $this->SendMail($Data);
        $notifi['title']=($user->lang_perfix=="en")?'New gig successfully posted':"تم نشر وظيفة جديدة بنجاح";
        // $notifi['deeplink']='gig/'.$gig->id;
        $notifi['devices'] = $this->userdevices($user);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'gig','item_id'=>$gig->id];

        $this->PushNotification($notifi);
        
    }
    public function SendNewGig($user=null,$gig=null,$keyskills=null)
    {
        if ($user&&$gig&&$keyskills) {
            $Data['username']=$user->username;
            $Data['gig']=$gig;
            // for customer 
            $this->ToEmails=$user->email;
            $this->Subject='New Gig Posted';
            $this->Subject_ar='وظيفة جديدة مقدّمة';
            $this->Lang=$user->lang_perfix;
            $this->Template='CustomerNewGig';
            $this->SendMail($Data);
            $notifi['title']=($user->lang_perfix=="en")?'New gig successfully posted':"تم نشر وظيفة جديدة بنجاح";
            // $notifi['deeplink']='gig/'.$gig->id;
            $notifi['devices'] = $this->userdevices($user);
            $notifi['data'] = ['message'=>$notifi['title'],'type'=>'gig','item_id'=>$gig->id];
            $this->PushNotification($notifi);
            // for suppliers with keyskills 
            $usersToNoti = $this->GetUserBySkills($keyskills,$user->id);
            // var_dump($GHemails);exit;
            if (count($usersToNoti->emails)) {
                $this->ToEmails='info@flexigigs.com';
                $this->ToBcc = $usersToNoti->emails;
                $this->Subject='A New Gig Matches Your Skills!';
                $this->Template='NewGig';
                $this->SendMail($Data);
                $notifi['title'] = 'New ​Gig ​post that matches​ your key​ ​skills';
                // $notifi['deeplink']='gig/'.$gig->id;
                $notifi['devices'] = $usersToNoti->devices;
                $notifi['data'] = ['message'=>$notifi['title'],'type'=>'gig','item_id'=>$gig->id];
                // var_dump ($this->PushNotification($notifi));exit;
                $this->PushNotification($notifi);
            }
            // return $user->devices;
        }
    }
    public function GetUserBySkills($keyskills="",$sender_id=null)
    {
        if (!$keyskills && !$sender_id)
            return 0;
        $readytosearch = [];
        foreach ($keyskills as $key => $value) {
            $category = Category::where('id',$value)->first();
            if ($category) {
                $readytosearch[]=$category->slug;
            }
        }
        $usersToNoti = (object)[];
        $usersToNoti->emails = [];
        $usersToNoti->devices = [];
        foreach ($readytosearch as $key => $skill) {
            $users = User::where('skills','like','%'.$skill."%")->whereNotIn('id',[$sender_id])->get();
            $i = 0;
            foreach ($users as $user):
                if (!in_array($user->email, $usersToNoti->emails)) {
                    $usersToNoti->emails[]=$user->email;
                    $tokens = $this->userdevices($user);
                    if ($tokens) {
                        foreach ($tokens as $token) {
                            $usersToNoti->devices[] = $token; 
                        }
                    }
                }
            endforeach;
        }
        return $usersToNoti;
    }
    public function SendNewApplication($user=null,$gig=null,$application=null)
    {
        if ($user&&$gig&&$application) {
            $Data['gig'] = $gig;
            $Data['username'] = $user->username;
            $Data['application'] = $application;
            $this->ToEmails=$user->email;
            $this->Subject='New Application For Your Posted Gig';
            $this->Subject_ar='طلب جديد للحصول على الوظيفة';
            $this->Lang=$user->lang_perfix;
            $this->Template='NewApplication';
            $this->SendMail($Data);
            $notifi['title'] = ($this->Lang=="en")?'New​ Gig Application':"طلب جديد للحصول على الوظيفة";
            $notifi['devices'] = $this->userdevices($user);
            $notifi['data'] = ['message'=>$notifi['title'],'type'=>'application','item_id'=>$application->id];
            // $notifi['deeplink']='application/'.$application->id;
            $this->PushNotification($notifi);
        }
    }
    public function application​Accepted($customer=null,$supplier=null,$gig=null,$order=null)
    {
        if ($customer&&$supplier&&$gig&&$order) {
            // prepare data
            $Data['gig'] = $gig;
            $Data['order'] = $order;
            $price = Flexihelp::fixprice($gig,'gig');
            $Data['transaction_fee'] = $price->transaction;
            $Data['handling_commission'] = $price->handling;
            $Data['customer_total'] = $price->total_handling;
            $Data['supplier_total'] = $price->total_transaction;
            $Data['customer'] = $customer->username;
            $Data['supplier'] = $supplier->username;
            
            // payment email for customer HH
            $this->ToEmails=$customer->email;
            $this->Subject='Gig Application Accepted - New Order Request | #'.$order->id.' - '.$gig->title;
            $this->Subject_ar=' تمّ قبول طلبك للحصول على الوظيفة - طلب أمر عمل جديد | #'.$order->id.' - '.$gig->title;
            $this->Lang=$customer->lang_perfix;
            $this->Template='appacceptedhh';
            $this->SendMail($Data);
            // $notifi['title'] = 'New​ Order - Gig Application Accepted';
            // $notifi['devices'] = $this->userdevices($customer);
            // $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
            // $this->PushNotification($notifi);
            // mail to the supplier GH
            $this->ToEmails=$supplier->email;
            $this->Lang=$supplier->lang_perfix;
            $this->Subject='Gig Application Accepted - New Order Request | #'.$order->id.' - '.$gig->title;
            $this->Subject_ar=' تمّ قبول طلبك للحصول على الوظيفة - طلب أمر عمل جديد | #'.$order->id.' - '.$gig->title;
            $this->Template='appacceptedgh';
            $this->SendMail($Data);
            $notifi['title'] = ($this->Lang=='en')?'New​ Order - Gig Application Accepted':"أمر عمل جديد - تمّ قبول طلبك للحصول على الوظيفة";
            $notifi['devices'] = $this->userdevices($supplier);
            $notifi['data'] = ['message'=>$notifi['title'],'type'=>'mygig','item_id'=>$order->id];
            $this->PushNotification($notifi);
            // send email to rejected Gighunters
            if ($gig->id) {
                $applications = Applications::where(['gig_id'=>$gig->id,'status'=>0])->with('supplier')->get();
                $emails = [];
                foreach ($applications as $application) {
                    // var_dump($application->supplier);exit;
                    $emails[] = $application->supplier->email;
                    $notifi['title'] = 'Gig Application not accepted - '.$gig->title;
                    $notifi['body'] = 'your application has been automticly removed form your applications list';
                    $notifi['deeplink'] = 'donotopenapp';
                    $notifi['devices'] = $this->userdevices($application->supplier);
                    $this->PushNotification($notifi);
                }
                // delete applications
                Applications::where(['gig_id'=>$gig->id,'status'=>0])->delete();
                $this->ToEmails="info@flexigigs.co";
                $this->ToBcc = $emails;            $notifi['data'] = ['message'=>$notifi['title'],'type'=>'mygig','item_id'=>$order->id];


                $this->Subject='Gig Application not accepted ☹ | '.$gig->title;
                $this->Template='application​Regect';
                $this->SendMail($Data);
            
            }
            // send email 
        }
    }
    /*  
        event = New Service Order Request
        status0
    */
    public function requestCallback($order='')
    {
        // =====> prepering
        $Data['order'] = $order;
        $price = Flexihelp::fixprice($order->request,'service');
        $Data['price'] = $price;
        // service request GH
        $this->ToEmails  = $order->supplier->email;
        $this->Subject   = 'New Service Request awaiting, '.$order->request->customer->username;
        $this->Subject_ar= 'New Service Request awaiting, '.$order->request->customer->username;
        $this->Lang      = $order->supplier->lang_perfix;
        $this->Template  = 'requestCallback';
        $this->SendMail($Data);
        $notifi['title']   = ($this->Lang=='en')?'New Service Request awaiting, '.$order->request->customer->username.'. chick it out!':'New Service Request awaiting, '.$order->request->customer->username.'. chick it out!';
        $notifi['devices'] = $this->userdevices($order->supplier);
        $notifi['data']    = ['message'=>$notifi['title'],'type'=>'mygig','item_id'=>$order->id];
        $this->PushNotification($notifi);
    }
    public function serviceRequest($order=null)
    {
        // =====> prepering
        $Data['service_request'] = $order->request;
        $Data['order'] = $order;
        $price = Flexihelp::fixprice($order->request,'service');
        $Data['transaction_fee'] = $price->transaction;
        $Data['supplier_total'] = $price->total_handling;
        $Data['customer'] = $order->customer->username;
        $Data['supplier'] = $order->supplier->username;
        /*// service request GH
        $this->ToEmails=$order->supplier->email;
        $this->Subject='Service Request - New Order | #'.$order->id.' - '.$order->request->name;
        $this->Subject_ar='طلب أمر عمل جديد | #'.$order->id.' - '.$order->request->name;
        $this->Lang=$order->supplier->lang_perfix;
        $this->Template='ServiceRequestGH';
        $this->SendMail($Data);
        $notifi['title'] = ($this->Lang=='en')?$this->Subject:$this->Subject_ar;
        $notifi['devices'] = $this->userdevices($order->supplier);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'mygig','item_id'=>$order->id];
        $this->PushNotification($notifi);*/
        // service request HH
        $this->ToEmails=$order->customer->email;
        $this->Subject='Service Request - New Order | #'.$order->id.' - '.$order->request->name;
        $this->Subject_ar='طلب أمر عمل جديد | #'.$order->id.' - '.$order->request->name;
        $this->Lang=$order->customer->lang_perfix;
        $this->Template='ServiceRequestHH';
        $this->SendMail($Data);
        $notifi['title'] = ($this->Lang=='en')?$this->Subject:$this->Subject_ar;
        $notifi['devices'] = $this->userdevices($order->customer);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id,'user_type'=>'HH'];
        $this->PushNotification($notifi);
        // send email 
    }
   
    public function gigCanceled($emails=null,$gig=null,$users=null)
    {
        if ($emails&&$gig) {
            $Data['gig'] = $gig;
            $this->ToEmails="info@flexigigs.co";
            $this->ToBcc = $emails;
            $this->Subject='Gig Applied For has been Canceled | '.$gig->title;
            $this->Template='cancelGig';
            $this->SendMail($Data);
            $notifi['title'] = 'Gig Applied For has been Canceled - '.$gig->title;
            $notifi['body'] = 'your application has been automticly removed form your applications list';
            $notifi['devices'] = $this->userquery($users);
            $notifi['deeplink'] = 'dontgotoapp';
            $notifi['body'] = 'your application has been automticly removed';
            $this->PushNotification($notifi);
        }   
    }
    public function OrderDelivery($order=null)
    {
        if ($order) {
            $data['order'] = $order;
            if ($order->type == 1) {
            // will it`s request
                $this->ToEmails=$order->customer->email;
                $this->Lang=$order->customer->lang_perfix;
                $this->Subject='Order Completed | # '.$order->id.' - '.$order->request->name;
                $this->Subject_ar='إنجاز أمر العمل | # '.$order->id.' - '.$order->request->name;
                $this->Template='OrderDeliveryService';
                $this->SendMail($data);
            }elseif($order->type == 2){
                // so it`s accepted application
                $this->Lang=$order->customer->lang_perfix;
                $this->ToEmails=$order->customer->email;
                $this->Subject='Order Completed | # '.$order->id.' - '.$order->application->title;
                $this->Subject_ar='إنجاز أمر العمل | # '.$order->id.' - '.$order->application->title;
                $this->Template='OrderDeliveryGig';
                $this->SendMail($data);
            }
            $notifi['title']=($this->Lang)?'Order #'.$order->id.' has been completed':"تم إنجاز أمر العمل".'#'.$order->id;
            $notifi['devices'] = $this->userdevices($order->customer);
            $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
            $this->PushNotification($notifi);
            return true;
        }else{
            return false;
        }
        
    }
    public function OrderFinished($order=null)
    {
        if ($order) {
            if ($order->type == 1) {
            // will it`s request
                $price = Flexihelp::fixprice($order->request,'service');
                $data['price'] = $price->price;
                $data['transaction_fee'] = $price->transaction;
                $data['total'] = $price->total_transaction;
                $data['order'] = $order;
                $this->ToEmails=$order->supplier->email;
                $this->Lang=$order->supplier->lang_perfix;
                $this->Subject='Congratulations! Order Delivery Accepted - #'.$order->id.' - '.$order->request->name;
                $this->Subject_ar='تهانينا! تمّ قبول أمر العمل المسلّم | #'.$order->id.' - '.$order->request->name;
                $this->Template='OrderDeliveryAcceptedService';
                $this->SendMail($data);
                // ============admin mail
                $this->ToEmails=$this->GetAdminEmails();
                $this->Subject='#'.$order->id.' Order Delivery Accepted - Release Payment';
                $this->Template='AdminOrderDeliveryAcceptedService';
                
                $this->SendMail($data);
                $notifi['title']=($this->Lang=='en')?'Congratulations! Order Delivery Accepted #'.$order->id.' - '.$order->request->name:"تهانينا! تم قبول أمر العمل المسلّم - #".$order->id." - ".$order->request->name;
            }elseif($order->type == 2){
                // so it`s accepted application
                $price = Flexihelp::fixprice($order->application,'gig');
                $data['price'] = $price->price;
                $data['transaction_fee'] = $price->transaction;
                $data['total'] = $price->total_transaction;
                $data['order'] = $order;
                $this->ToEmails=$order->supplier->email;
                $this->Lang=$order->supplier->lang_perfix;
                $this->Subject='Congratulations! Order Delivery Accepted | # '.$order->id.' - '.$order->application->title ;
                $this->Subject_ar='تهانينا! تمّ قبول أمر العمل المسلّم | #'.$order->id.' - '.$order->request->name;
                $this->Template='OrderDeliveryAcceptedGig';
                $this->SendMail($data);
                // ==============admin mail
                $this->ToEmails=$this->GetAdminEmails();
                $this->Subject='#'.$order->id.' Order Delivery Accepted - Release Payment';
                $this->Template='AdminOrderDeliveryAcceptedGig';
                $this->SendMail($data);
                $notifi['title']=($this->Lang=='en')?'Congratulations! Order Delivery Accepted #'.$order->id.' - '.$order->application->title :'تهانينا! تم قبول أمر العمل المسلّم - #'.$order->id.' - '.$order->application->title;
            }
            $notifi['devices'] = $this->userdevices($order->supplier);
            $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
            $this->PushNotification($notifi);
            return true;
        }else{
            return false;
        }
    }
    public function SendNewReview($review=null)
    {
        if ($review->type==1) {
            // supplier submit review

            $Data['review'] = $review;
            // =====>send message to supplier
            $this->Lang=$review->order->customer->lang_perfix;
            $this->ToEmails=$review->order->customer->email;
            $this->Subject='Review Submitted Successfully';
            $this->Subject_ar='تمّ تقديم المراجعة بنجاح';
            $this->Template='reviewForSubmitter';
            $this->SendMail($Data);
            // =====>send message to customer
            $this->Lang=$review->order->supplier->lang_perfix;
            $this->ToEmails=$review->order->supplier->email;
            $this->Subject='New Review Submitted';
            $this->Subject_ar=' مراجعة جديدة مقدّمة';
            $this->Template='reviewforSubmittedUser';
            $notifi['title']=($review->order->supplier->lang_perfix=="en")?'New Review Submitted to your profile':"مراجعة جديدة مقدّمة إلى ملفك الشخصي";
            $notifi['devices'] = $this->userdevices($review->order->supplier);
            $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myprofile','item_id'=>$review->order->supplier->username];
            $this->PushNotification($notifi);
            $this->SendMail($Data);
        }elseif($review->type==2){
            // customer submit review

            $Data['review'] = $review;
            // =====>send message to customer
            $this->ToEmails=$review->order->supplier->email;
            $this->Lang=$review->order->supplier->lang_perfix;
            $this->Subject='Review Submitted Successfully';
            $this->Subject_ar='تمّ تقديم المراجعة بنجاح';
            $this->Template='reviewForSubmitter';
            $this->SendMail($Data);
            $notifi['title']=($review->order->customer->lang_perfix=="en")?'New Review Submitted to your profile':"مراجعة جديدة مقدّمة إلى ملفك الشخصي";
            $notifi['devices'] = $this->userdevices($review->order->customer);
            $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myreviews','item_id'=>$review->order->supplier->username];
            $this->PushNotification($notifi);
            // =====>send message to supplier
            $this->ToEmails=$review->order->customer->email;
            $this->Lang=$review->order->customer->lang_perfix;
            $this->Subject='New Review Submitted';
            $this->Subject_ar=' مراجعة جديدة مقدّمة';
            $this->Template='reviewforSubmittedUser';
            $this->SendMail($Data);
        }
    }
    public function markCompleted($order=null)
    {
            $Data['order'] = $order;
            $Data['title'] = $title = ($order->type == 1)?$order->request->name:$order->application->title;
            if ($order->type == 1) {
                $price = Flexihelp::fixprice($order->request,'service');
            }else{
                $price = Flexihelp::fixprice($order->application,'gig');
            }
            $Data['price'] = $price->price;
            $Data['transaction_fee'] = $price->transaction;
            $Data['total'] = $price->total_transaction;
            // =====>send message to customer
            $this->ToEmails=$order->customer->email;
            $this->Lang=$order->customer->lang_perfix;
            $this->Subject='Order #'.$order->id.' - '.$title.' Marked Completed by FlexiGigs Admin';
            $this->Subject_ar='إقرار مسؤول فليكس غيغز بـ "إنجاز" أمر العمل رقم '.$order->id.' - '.$title;
            $this->Template='markCompletedHH';
            $this->SendMail($Data);
            // =====>send message to supplier
            $this->ToEmails=$order->supplier->email;
            $this->Lang=$order->supplier->lang_perfix;
            $this->Subject='Congratulations! Order #'.$order->id.' - '.$title.' Marked as Completed ';
            $this->Subject_ar=' تهانينا! تمّ اعتبار أمر العمل رقم'.$order->id.' - '.$title.'"منجزًا"';
            $this->Template='markCompletedGH';
            $this->SendMail($Data);
            // =====>send message to Admin
            $this->ToEmails=$this->GetAdminEmails();
            $this->Subject=' Order #'.$order->id.' - '.$title.' Marked Done by admin - Release Payment';
            $this->Template='markCompletedAdmin';
            $this->SendMail($Data);
    }
    public function cancelOrder($order=null)
    {
        $Data['order'] = $order;
        $Data['title'] = $title = ($order->type == 1)?$order->request->name:$order->application->title;
        if ($order->type == 1) {
            $price = Flexihelp::fixprice($order->request,'service');
        }else{
            $price = Flexihelp::fixprice($order->application,'gig');
        }
        $Data['price'] = $price->price;
        $Data['transaction_fee'] = $price->handling;
        $Data['total'] = $price->total_handling;
        // =====>send message to customer
        $this->ToEmails=$order->customer->email;
        $this->Lang=$order->customer->lang_perfix;
        $this->Subject='Order #'.$order->id.' - '.$title.' Canceled by Flexi Admin';
        $this->Subject_ar='تمّ إلغاء أمر العمل رقم'.$order->id.' - '.$title.' بواسطة مسؤل فليكس غيغز';
        $this->Template='cancelOrderHH';
        $this->SendMail($Data);
        // =====>send message to supplier
        $this->ToEmails=$order->supplier->email;
        $this->Lang=$order->supplier->lang_perfix;
        $this->Subject='Order #'.$order->id.' - '.$title.' Canceled by Flexi Admin ';
        $this->Subject_ar='تمّ إلغاء أمر العمل رقم'.$order->id.' - '.$title.' بواسطة مسؤل فليكس غيغز';
        $this->Template='cancelOrderGH';
        $this->SendMail($Data);
        // =====>send message to Admin
        $this->ToEmails=$this->GetAdminEmails();
        $this->Subject=' Order #'.$order->id.' - '.$title.' Canceled by Flexi Admin';
        $this->Template='cancelOrderAdmin';
        $this->SendMail($Data);
    }
    public function changeToPaid($order=null)
    {
        $Data['order'] = $order;
        $Data['title'] = $title = ($order->type == 1)?$order->request->name:$order->application->title;
        if ($order->type == 1) {
                $price = Flexihelp::fixprice($order->request,'service');
            }else{
                $price = Flexihelp::fixprice($order->application,'gig');
            }
        $Data['price'] = $price->price;
        $Data['transaction_fee'] = $price->transaction;
        $Data['total'] = $price->total_transaction;
        $this->ToEmails=$order->supplier->email;
        $this->Lang=$order->supplier->lang_perfix;
        $this->Subject='Congratulations! Order #'.$order->id.' - '.$title.' Marked as paid form system admin ';
        $this->Subject_ar='تهانينا! لمر العمل #'.$order->id.' - '.$title.' تم  تحويل مستقحقاته المادية ';
        $this->Template='changeToPaid';
        $this->SendMail($Data);
    }
    public function newMessageReceived($message=null)
    {
        $Data['messagedata'] = $message;
        $Data['message_to'] = $message->message_to;
        $Data['message_from'] = $message->message_from;
        if ($message->order_id==0) {
            $this->ToEmails=$message->message_to->email;
            $this->Lang=$message->message_to->lang_perfix;
            $this->Subject='New Message Received';
            $this->Subject_ar=' رسالة جديدة مستلمة';
            $this->Template='newMessageReceived';
            $this->SendMail($Data);
        }else{
            $Data['title'] = $title = ($message->order->type == 1)?$message->order->request->name:$message->order->application->title;
            $Data['user_from'] = $user_from = ($message->id_from == 0)?"Admin":$message->message_from;
            $Data['user_to'] = $user_to = ($message->id_to == 0)?"Admin":$message->message_to;
            // to admin
            $this->ToEmails  = $this->GetAdminEmails();
            $this->Subject   = 'New Message Conflect Received';
            $this->Template  = 'newConflectReceived';
            $this->SendMail($Data);
            // to customer
            $Data['userdata']= $message->order->customer;
            $this->Lang      = $message->order->customer->lang_perfix;
            $this->ToEmails  = $message->order->customer->email;
            $this->Subject   = 'New Message Conflect Received';
            $this->Subject_ar=' رسالة جديدة مستلمة';
            $this->Template  = 'conflectReceivedtouser';
            $this->SendMail($Data);
            // to supplier
            $Data['userdata'] = $message->order->supplier;
            $this->Lang       = $message->order->supplier->lang_perfix;
            $this->ToEmails   = $message->order->supplier->email;
            $this->Subject    = 'New Message Conflect Received';
            $this->Subject_ar=' رسالة جديدة مستلمة';
            $this->Template   = 'conflectReceivedtouser';
            $this->SendMail($Data);                    
            
        }
    }
    protected function GetAdminEmails()
    {
         $AdminEmails=array();
         $Admins=User::join('role_user', 'users.id', '=', 'role_user.user_id')->where([['role_id',1],['receive_noti',1]])->get();
         foreach ($Admins as $Admin):$AdminEmails[]=$Admin->email;endforeach;
         return $AdminEmails;
    }
     /**
     * Send To User Approved Notification By Mail
     */
    
    public function SendVerifyMail($user)
    {       
        //Send user details
        $Data['token']=$user->token;
        $Data['name']=$user->username;
        $Data['email']= $email = $user->email;
        $this->ToEmails  = $email;
        $this->FromEmail = "admin@Flexigigs.com";
        $this->Lang      = $user->lang_perfix;
        $this->Subject   = 'Confirm your account, '.$user->username;
        $this->Subject_ar= 'تأكيد حسابك, '.$user->username;
        $this->Template  = 'EmailVerify';
        $this->SendMail($Data);
        return response()->json(['errors'=>[],'message'=>'Please check your email! A verification email with activation link has been sent to your email address.'],200);
    }
    /*  
        event = GH Rejected Order Request
        status0
        falier2
    */
    public function orderRejected($order)
    {
        $this->ToEmails  = $order->request->customer->email;
        $this->Lang      = $order->request->customer->lang_perfix;
        $this->Subject   = 'Your request for “'.$order->request->name.'” has been declined by '.$order->supplier->username;
        $this->Subject_ar= 'Your request for “'.$order->request->name.'” has been declined by '.$order->supplier->username;
        $this->Template  = 'orderRejected';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?$this->Subject:$this->Subject_ar;
        $notifi['devices'] = $this->userdevices($order->customer);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);
    }
    /*  
        event = GH Rejected Order Request
        status0
        falier6
    */
    public function requestNoAction($order)
    {
        $this->ToEmails  = $order->request->customer->email;
        $this->Lang      = $order->request->customer->lang_perfix;
        $this->Subject   = 'Unfortunately, no response from '.$order->supplier->username.'|“'.$order->request->name;
        $this->Subject_ar   = 'Unfortunately, no response from '.$order->supplier->username.'|“'.$order->request->name;
        $this->Template  = 'requestNoAction';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?$this->Subject:$this->Subject_ar;
        $notifi['devices'] = $this->userdevices($order->customer);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);
    }
    /*  
        event = New Service Order Request
        status1
    */
    public function OrderAccepted($order)
    {

        $this->ToEmails  = $order->request->customer->email;
        $this->Lang      = $order->request->customer->lang_perfix;
        $this->Subject   = 'Your service request for “'.$order->request->name.'” has been accepted by '.$order->supplier->username;
        $this->Subject_ar= 'Your service request for “'.$order->request->name.'” has been accepted by '.$order->supplier->username;
        $this->Template  = 'OrderAccepted';
        $Data['order'] = $order;
        $Data['price'] = Flexihelp::fixprice($order->request,'service');
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'Great news! Your service request for “'.$order->request->name.'” has been accepted by
        '.$order->supplier->username.'. Please click here to pay':'Great news! Your service request for “'.$order->request->name.'” has been accepted by
        '.$order->supplier->username.'. Please click here to pay';
        $notifi['devices'] = $this->userdevices($order->supplier);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);
    }
    /*
        event = GH didn’t respond  within 24 hours
        status1
        failer1
    */
    public function paymentNoActionGH($order)
    {
        $this->ToEmails  = $order->request->supplier->email;
        $this->Lang      = $order->request->supplier->lang_perfix;
        $this->Subject   = 'Unfortunately, no response from '.$order->customer->username.' | “'.$order->request->name.'”';
        $this->Subject_ar= 'Unfortunately, no response from '.$order->customer->username.' | “'.$order->request->name.'”';
        $this->Template  = 'paymentNoActionGH';
        $Data['order'] = $order;
        $Data['price'] = Flexihelp::fixprice($order->request,'service');
        $this->SendMail($Data); 
        // push notification
        $notifi['title']=($this->Lang=='en')?'Unfortunately, we’ll have to cancel the order requested by '.$order->customer->username.' for
                            “'.$order->request->name.'” service due to non-payment.':'Unfortunately, we’ll have to cancel the order requested by '.$order->customer->username.' for
                            “'.$order->request->name.'” service due to non-payment.';
        $notifi['devices'] = $this->userdevices($order->supplier);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);
    }
    public function paymentNoActionHH($order)
    {
        $this->ToEmails  = $order->request->supplier->email;
        $this->Lang      = $order->request->supplier->lang_perfix;
        $this->Subject   = 'Your service request for “'.$order->request->name.'” has been cancelled';
        $this->Subject_ar   = 'Your service request for “'.$order->request->name.'” has been cancelled';
        $this->Template  = 'paymentNoActionHH';
        $Data['order'] = $order;
        $Data['price'] = Flexihelp::fixprice($order->request,'service');
        $this->SendMail($Data); 
        // push notification
        $notifi['title']=($this->Lang=='en')?'Ready, set, GO! You may now begin working on your new order “'.$order->request->name.'” Click here to view your order.':'Ready, set, GO! You may now begin working on your new order “'.$order->request->name.'” Click here to view your order.';
        $notifi['devices'] = $this->userdevices($order->supplier);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);
    }
    /*
        HH Paid (CC) OR Fawry confirmation of Cash Payment
        status2
    */
    public function proceed_to_payment($order)
    {
        $price = Flexihelp::fixprice($order->request,'service');
        $Data['price'] = $price;
        $this->ToEmails  = $order->supplier->email;
        $this->Lang      = $order->supplier->lang_perfix;
        $this->Subject   = 'Ready, set, GO! You may now begin '.$order->supplier->username.' ';
        $this->Subject_ar= 'Ready, set, GO! You may now begin '.$order->supplier->username.' ';
        $this->Template  = 'proceed_to_payment';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'Unfortunately, your service request for “'.$order->request->name.'” has been cancelled due to
        non-payment.':'Unfortunately, your service request for “'.$order->request->name.'” has been cancelled due to
        non-payment.';
        $notifi['devices'] = $this->userdevices($order->supplier);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);
        $this->serviceRequest($order);

    }
    public function beforedeadline($order)
    {
        /*to the customer HH */
        $this->ToEmails  = $order->customer->email;
        $this->Lang      = $order->customer->lang_perfix;
        $this->Subject   = 'Reminder 1: do you mind extending the deadline?! :$';
        $this->Subject_ar= 'Reminder 1: do you mind extending the deadline?! :$';
        $this->Template  = 'HHbeforedeadline';
        $Data['order'] = $order;
        $this->SendMail($Data);
        $notifi['title']=($this->Lang=='en')?'Reminder 1: do you mind extending the deadline?! ':'Reminder 1: do you mind extending the deadline?! ';
        $notifi['devices'] = $this->userdevices($order->customer);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);

   /*     $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'Reminder 1: Reminder 1: do you mind extending the deadline?! :$':'Reminder 1: Reminder 1: do you mind extending the deadline?! :$';
        $notifi['devices'] = $this->userdevices($order->customer);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);

        $this->ToEmails  = $order->supplier->email;
        $this->Lang      = $order->supplier->lang_perfix;*/

        /*To the supplier GH */
        $this->ToEmails  = $order->supplier->email;
        $this->Lang      = $order->supplier->lang_perfix;
        $this->Subject   = 'Reminder: Project due date is 2 days away!';
        $this->Subject_ar= 'Reminder: Project due date is 2 days away!';
        $this->Template  = 'GHbeforedeadline';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'Reminder: Project due date is 2 days away!':'Reminder: Project due date is 2 days away!';
        $notifi['devices'] = $this->userdevices($order->supplier);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);
    }
    public function deadlineday($order)
    {
        $this->ToEmails  = $order->customer->email;
        $this->Lang      = $order->customer->lang_perfix;
        $this->Subject   = 'Reminder 2: still considering deadline extension? :$';
        $this->Subject_ar= 'Reminder 2: still considering deadline extension? :$';
        $this->Template  = 'HHdeadlineday';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'Reminder 2: Still considering deadline extension?':'Reminder 2: Still considering deadline extension?';
        $notifi['devices'] = $this->userdevices($order->customer);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);

        $this->ToEmails  = $order->supplier->email;
        $this->Lang      = $order->supplier->lang_perfix;
        $this->Subject   = 'Alert: tick-tock!';
        $this->Subject_ar= 'Alert: tick-tock!';
        $this->Template  = 'GHdeadlineday';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'Alert: tick-tock, tick-tock!':'Alert: tick-tock, tick-tock!';
        $notifi['devices'] = $this->userdevices($order->supplier);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);
    }
    public function afterdeadline2days($order)
    {
        $this->ToEmails  = $order->customer->email;
        $this->Lang      = $order->customer->lang_perfix;
        $this->Subject   = '“'.$order->request->name.'” service is now overdue ';
        $this->Subject_ar= '“'.$order->request->name.'” service is now overdue ';
        $this->Template  = 'HHafterdeadline2days';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'“'.$order->request->name.'” service is now overdue ':'“'.$order->request->name.'” service is now overdue ';
        $notifi['devices'] = $this->userdevices($order->customer);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);

        /*
        $this->ToEmails  = $order->supplier->email;
        $this->Lang      = $order->supplier->lang_perfix;
        $this->Subject   = 'GHafterdeadline2days';
        $this->Subject_ar= 'GHafterdeadline2days';
        $this->Template  = 'GHafterdeadline2days';
        $Data['order'] = $order;
        $this->SendMail($Data);*/
    }
    public function afterdeadline4days($order)
    {
        /*mail to the customer HH */
        $this->ToEmails  = $order->customer->email;
        $this->Lang      = $order->customer->lang_perfix;
        $this->Subject   = 'Time to Refund “'.$order->customer->username.'”';
        $this->Subject_ar= 'Time to Refund “'.$order->customer->username.'”';
        $this->Template  = 'HHafterdeadline4days';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'It is now time for refund!':'It is now time for refund!';
        $notifi['devices'] = $this->userdevices($order->customer);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);

        /*mail to the admin*/

        $this->ToEmails  = 'info@road9media.com';
        // $this->Lang      = $order->customer->lang_perfix;
        $this->Subject   = 'Alert, it is 4 days past deadline!';
        $this->Subject_ar= 'Alert, it is 4 days past deadline!';
        $this->Template  = 'adminAfter4Days';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'It is now time for refund!':'It is now time for refund!';
        $notifi['devices'] = $this->userdevices($order->customer);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);
/*
        $this->ToEmails  = $order->supplier->email;
        $this->Lang      = $order->supplier->lang_perfix;
        $this->Subject   = 'GHafterdeadline4days';
        $this->Subject_ar= 'GHafterdeadline4days';
        $this->Template  = 'GHafterdeadline4days';
        $Data['order'] = $order;
        $this->SendMail($Data);*/
    }

    public function DeadlineExtension($order){
        /*mail to the customer HH */
        $this->ToEmails  = $order->supplier->email;
        $this->Lang      = $order->supplier->lang_perfix;
        $this->Subject   = 'Woohooo! “'.$order->customer->username.'” has extended the deadline ☺';
        $this->Subject_ar= 'Woohooo! “'.$order->customer->username.'” has extended the deadline ☺';
        $this->Template  = 'deadlineExtension';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'Woohooo! “'.$order->customer->username.'” has extended the deadline ☺':'Woohooo! “'.$order->customer->username.'” has extended the deadline ☺';
        $notifi['devices'] = $this->userdevices($order->supplier);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);
    }

    public function ClaimRefund($order){
        /*mail to the customer HH */
        $this->ToEmails  = $order->customer->email;
        $this->Lang      = $order->customer->lang_perfix;
        $this->Subject   = 'Refund request under processing';
        $this->Subject_ar= 'Refund request under processing';
        $this->Template  = 'HHclaimRefund';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'Refund against Order ID:
         # “'.$order->id.'”-"'.$order->request->name.'"  is under processing.':'Refund against Order ID:# “'.$order->id.'” - "'.$order->request->name.'"  is under processing.';
        $notifi['devices'] = $this->userdevices($order->customer);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);

        /*mail to the customer GH */
        $this->ToEmails  = $order->supplier->email;
        $this->Lang      = $order->supplier->lang_perfix;
        $this->Subject   = 'We are refunding “'.$order->customer->username.'”!';
        $this->Subject_ar= 'We are refunding “'.$order->customer->username.'”!';
        $this->Template  = 'GHclaimRefund';
        $Data['order'] = $order;
        $this->SendMail($Data);
        // push notification
        $notifi['title']=($this->Lang=='en')?'We are refunding “'.$order->customer->username.'”! .':'We are refunding “'.$order->customer->username.'”! .';
        $notifi['devices'] = $this->userdevices($order->supplier);
        $notifi['data'] = ['message'=>$notifi['title'],'type'=>'myorders','item_id'=>$order->id];
        $this->PushNotification($notifi);

    }

    protected function SendMail($Data)
    {        
        // var_dump($this->ToBcc);die();
        return Mail::send('emails.'.$this->Lang.'.'.$this->Template, $Data, function ($message) {
            $message->from($this->FromEmail, $this->From);
            $message->to($this->ToEmails);
            $subject = ($this->Lang=="en")?$this->Subject:$this->Subject_ar;
            if ($this->ToBcc) 
                $message->bcc($this->ToBcc);
            $message->subject($subject);
        });
    }
    protected function PushNotification($noti)
    {
        $noti = (object)$noti;
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($noti->title);
        $notificationBuilder->setSound('default')
                            ->setIcon(url('images/favicon/apple-icon-192x192.png'))
                            ->setColor('#083e52');
        if (@$noti->body)
        $notificationBuilder->setBody($noti->body);
        if (@$noti->deeplink)
            $notificationBuilder->setClickAction('http://crowddev.road9media.info/'.$noti->deeplink);

        $dataBuilder = new PayloadDataBuilder();
        if(@$noti->data)
            $dataBuilder->addData($noti->data);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        // You must change it to get your tokens
        // var_dump($noti->tokens); exit;
        if ($noti->devices) {
            $tokens = $noti->devices;
            $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

            $response['numberSuccess'] = $downstreamResponse->numberSuccess();
            $response['numberFailure'] = $downstreamResponse->numberFailure();
            $response['numberModification'] = $downstreamResponse->numberModification();
            //return Array - you must remove all this tokens in your database
            $response['tokensToDelete'] = $downstreamResponse->tokensToDelete();

            //return Array (key : oldToken, value : new token - you must change the token in your database )
            $response['tokensToModify'] = $downstreamResponse->tokensToModify();

            //return Array - you should try to resend the message to the tokens in the array
            $response['tokensToRetry'] = $downstreamResponse->tokensToRetry();

            // return Array (key:token, value:errror) - in production you should remove from your database the tokens present in this array
            $response['tokensWithError'] = $downstreamResponse->tokensWithError();

            return $response;

        }
    }
    protected function userdevices($user=null)
    {
        $tokens = [];
        if ($user) {
            foreach ($user->devices as $device) {
                $tokens[] = $device->device_id;
            }
            return $tokens;
        }
    }
    protected function userquery($users=null)
    {
        $readytokens = [];
        if (count($users)) {
            foreach ($users as $user) {
                $tokens = $this->userdevices($user);
                if ($tokens) {
                    foreach ($tokens as $token) {
                        $readytokens[] = $token; 
                    }
                }
            }
            return $readytokens;
        }
    }

}