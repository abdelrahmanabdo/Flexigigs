<?php
/**
 * Created by Road9media.
 * User: pokevirus
 * Date: 13/03/18
 * Time: 05:06 م
 */

namespace App\Helpers;

/**
 * Class index
 * @package Road9media\fawry
 *
 */
use GuzzleHttp\Client;

class Fawry
{
    public $FAWRY_MERCHANT;

    public $merchantCode;

    public $url;

    public $fawryRefNo;

    public $merchantRefNum;

    public $customerProfileId;

    public $customerEmail;

    public $customerName;

    public $customerMobile;

    public $paymentMethod;

    public $amount;

    public $currencyCode;

    public $description;

    public $chargeItems;

    public function __construct()
    {
        $this->merchantCode = env("fawry_merchant",'test');
        if (env('fawry_url','Sandbox') == "Sandbox")
            $this->url      = "https://atfawry.fawrystaging.com/";
        else
            $this->url      = "https://www.atfawry.com/";
        if (env('merchant','test')) {
            $this->FAWRY_MERCHANT = env('FAWRY_MERCHANT','jZmr8qKqbf8=');
        }
    }
    public function checkOutLink($type,$item,$callback,$lang){   
        if ($type=="service") {
            $price = $item->service->price_data->total_handling_payment;
            $title = $item->name;
            $item_details = $item->service;
        }else{
            $price = $item->gig->price_data->total_handling_payment;
            $title = $item->title;
            $item_details = $item->gig;
        }
        $this->merchantRefNum = $item_details->id.'00'.$item->id;
        $this->customerName   = $item->customer->username;
        $this->customerMobile = $item->customer->phone;
        $this->customerEmail  = $item->customer->email;
        // create payment link
        $data['merchant']       = $this->FAWRY_MERCHANT;
        $data['lang']           = ($lang=="en")?"en-gb":"ar-eg";
        $data['merchantRefNum'] = $this->merchantRefNum;
        $data['customerName']   = $this->customerName;
        $data['mobile']         = $this->customerMobile;
        $data['email']          = $this->customerEmail;
        $data['order']          = json_encode([['productSKU'=>$item->id,'title'=>$title,'description'=>$item->description,'price'=>$price,'quantity'=>1]]);
        // MerchantURL/merchatCallbakPage?MerchantRefNo=123456&FawryRefNo=9990076204&OrderStatus=NEW&Amount=300.0&MessageSignature=5AD9731AE0FF009D586E6FB1F5CE26F8
        // $callback_parameters = ['MerchantRefNo'=>$this->merchantRefNum,'FawryRefNo'];
        $data['redirectToURL']=$callback;
        $url = $this->url.'ECommercePlugin/checkout.jsp?'.http_build_query($data);
        return $url;
    }
    public function checkPaymentStatus($item)
    {
        $data['merchantCode']      = $this->FAWRY_MERCHANT;
        $data['merchantRefNumber'] = $this->merchantRefNumber;
        $data['signature']         = $this->signature();
        $client = new Client();
        $result = $client->post($this->url.'ECommerceWeb/Fawry/cards/cardToken',$data);
        if ($result->getStatusCode()==200) {
            return (object)['status'=>true,'data'=>$result->getBody()];
        }else{
            return (object)['status'=>false,'data'=>$result->getBody()->statusDescription];
        }
    }
    public function signature()
    {
        $hashKey       = "478ff8dc884a44adb2d8d2a8d228773f";
        $amount        = $this->amount;
        $fawryRefNo    = $this->fawryRefNo;
        $merchantRefNum= $this->merchantRefNum;
        $orderStatus   = "NEW";
        $buffer        = $hashKey .$amount .$fawryRefNo .$merchantRefNum .$orderStatus;
        $seginature = md5($buffer);
        return $seginature;
    }

    public function create_cardToken($card_number,$year,$month,$cvv)
    {
        $data   = [ "merchantCode"=>$this->merchantCode,
                    "customerProfileId"=>$this->customerProfileId,
                    "customerMobile"=>$this->customerMobile,
                    "customerEmail"=>$this->customerEmail,
                    "cardNumber"=>$card_number,
                    "expiryYear"=>$year,
                    "expiryMonth"=>$month,
                    "cvv"=>$cvv];
        $client = new Client();
        $result = $client->post($this->url.'ECommerceWeb/Fawry/cards/cardToken',$data);
        if ($result->getStatusCode()==200) {
            return ['status'=>true,'message'=>$result->getBody()];
        }else{
            return ['status'=>false,'message'=>$result->getBody()->statusDescription];
        }
    }

    public function get_cardToken()
    {
        $data   = [ "merchantCode"=>$this->merchantCode,
                    "customerProfileId"=>$this->customerProfileId,
                    "signature"=>$this->seginature()];
        $client = new Client();
        $result = $client->get($this->url.'ECommerceWeb/Fawry/cards/cardToken',$data);
        if ($result->getStatusCode()==200) {
            return ['status'=>true,'message'=>$result->getBody()->statusDescription];
        }else{
            return ['status'=>false,'message'=>$result->getBody()->statusDescription];
        }
    }

    public function delete_cardToken()
    {
        $data   = [ "merchantCode"=>$this->merchantCode,
                    "customerProfileId"=>$this->customerProfileId,
                    "signature"=>$this->seginature(),
                    "cardToken"=>$this->cardToken()->card->token];
        $client = new Client();
        $result = $client->delete($this->url.'ECommerceWeb/Fawry/cards/cardToken',$data);
        if ($result->getStatusCode()==200) {
            return ['status'=>true,'message'=>$result->getBody()->statusDescription];
        }else{
            return ['status'=>false,'message'=>$result->getBody()->statusDescription];
        }
    }

    public function cardToken()
    {
        // return ($this->get_cardToken())?$this->get_cardToken():$this->create_cardToken();
        return $this->create_cardToken();
    }

    public function post_charge($type)
    {
        $data   = [ "merchantCode"=>$this->merchantCode,
                    "customerProfileId"=>$this->customerProfileId,
                    "customerMobile"=>$this->customerMobile,
                    "customerEmail"=>$this->customerEmail,
                    "paymentMethod"=>$type,
                    "amount"=>$this->amount,
                    "currencyCode"=>"EGP",
                    "description"=>"charge request description",
                    "chargeItems"=>[['itemID'=>$order->id,'description'=>"test","price"=>"20","quantity"=>1]],
                    "signature"=>$this->seginature(),
                    "cardToken"=>$this->cardToken()->card->token];
        $client = new Client();
        $result = $client->post($this->url.'ECommerceWeb/Fawry/payments/charge',$data);
        if ($result->getStatusCode()==200) {
            return ['status'=>true,'message'=>$result->getBody()->statusDescription];
        }else{
            return ['status'=>false,'message'=>$result->getBody()->statusDescription];
        }
    }



}