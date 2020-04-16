<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Flexihelp;

use App\User;
use App\Messages;
use Intervention\Image\ImageManagerStatic as Image;
use DB;
use Illuminate\Support\Facades\Validator;
class MessagesController extends Controller
{
  public function myMessages(Request $request , $id) {
    if ($id==0||$id) {
      $limit    = ($request->limit)?$request->limit:5;
      $offset   = ($request->page)?$request->page*$limit:0;
      $messages = Messages::where([['id_from',$id],['end_of_chat',"1"]])
                         ->orWhere([['id_to',$id],['end_of_chat',"1"]])
                         ->orderBy('created_at','desc')
                         ->with(['message_from','message_to','order.supplier','order.customer','order.request.service','order.application.gig'])
                         ->limit($limit)
                         ->offset($offset)
                         ->get();
      if (count($messages)) {
        if ($request['is_api']) {
          $data['status'] = true;
          $data['messages'] = $messages;
          return response()->json($data , 200);
        }else{
          $data['messages'] = $messages;
          if ($request->type =='admin.messages.direct') {
            return view($request->type.'.parts.item',$data);
          }else{
            return view($request->type.'.messages.parts.item',$data);
          }
        }
      }else{
        $data['status'] = false;
        $data['messages'] = [];
        $data['message'] = 'record not found';
        return response()->json($data , 200);
      }
    }else{
      $data['status'] = false;
      $data['messages'] = [];
      $data['message'] = 'bad parameters check DOC file';
      return response()->json($data , 400);
    }
  }
  public function conflects(Request $request , $id) {
    if ($id==0||$id) {
      $limit    = ($request->limit)?$request->limit:5;
      $offset   = ($request->page)?$request->page*$limit:0;
      $where[] = ['end_of_chat',"1"];
      $where[] = ['id_from',0];
      $orwhere[] = ['end_of_chat',"1"];
      $orwhere[] = ['id_to',0];
      if ($request->order_id) {
        $where[] = ['order_id',$request->order_id];
        $orwhere[] = ['order_id',$request->order_id];
      }
      $where[] = ['id_from',0];
      $messages = Messages::where($where)
                         ->orWhere($orwhere)
                         ->orderBy('created_at','desc')
                         ->with(['message_from','message_to','order','admin'])
                         ->limit($limit)
                         ->offset($offset)
                         ->get();
      if (count($messages)) {
        if ($request['is_api']) {
          $data['status'] = true;
          $data['messages'] = $messages;
          return response()->json($data , 200);
        }else{
          $data['messages'] = $messages;
          return view('admin.messages.conflects.parts.item',$data);
        }
      }else{
        $data['status'] = false;
        $data['message'] = 'record not found';
        return response()->json($data , 400);
      }
    }else{
      $data['status'] = false;
      $data['message'] = 'bad parameters check DOC file';
      return response()->json($data , 400);
    }
  }
  public function sendMessages(Request $request) {
    if ($request['exeed_limit']) {
        $data['status']= false;
        $data['message']=['attach'=>'file exeed limit'];
        return  response()->json($data,422);
      }
    $validator = Validator::make($request->all(), [
        'msg' => 'required',
      ]);
    if ($validator->fails()) {
      $error = $validator->errors()->toArray();
      $error['status']=false;
      return response()->json($error,422);
    }
      $dataToStore = $request->except(['exeed_limit','_token']);
      $dataToStore['end_of_chat'] = "1";
      if ($request->file('attach')) {//<============if file attached
        $upload_file = Flexihelp::upload($request->file('attach'),'chatattach');
        $dataToStore['attach'] = $upload_file->pathToSave;
        $dataToStore['type'] = $upload_file->type;
        $dataToStore['size'] = $upload_file->size;
      }
      $message = Messages::create($dataToStore);
      $messagetonoti =Messages::where('id',$message->id)->with(['message_to','message_from'])->first();
      if ($message) {
        if ($message->order_id) {
          $whereOrder = ['order_id',$message->order_id];
        }else{
          $whereOrder = ['order_id',0];
        }
        Messages::where([['id_from', $request->id_from],['id_to', $request->id_to],['end_of_chat',1],$whereOrder])
                ->whereNotIn('id',[$message['id']])
                ->orWhere([['id_to', $request->id_from],['id_from', $request->id_to],$whereOrder])
                ->update(['end_of_chat'=>0]);
      }
      $noti = new \App\Http\Controllers\NotificationController();
      $noti->newMessageReceived($messagetonoti);
      $data['status'] = true;
      $data['messages'] = Messages::find($message->id)->with(['message_from','message_to'])->get();
      $data['messageswith'] =['messages'=>Flexihelp::get_messages_between($request->id_from,$request->id_to)];
      return response()->json($data , 201);
  }
  public function messageWith(Request $request) {
    if ($request->id_from && $request->id_to ||$request->id_to=="0" ||$request->id_from=="0") {
      $limit             = ($request->limit)?$request->limit:5;
      $offset            = ($request->page)?$request->page*$limit:0;
      if ($request->order_id) 
      $messages = Flexihelp::get_messages_between($request->id_from,$request->id_to,$limit,$offset,$request->order_id);
      else
      $messages = Flexihelp::get_messages_between($request->id_from,$request->id_to,$limit,$offset);
      if ($messages) {
        if ($request['is_api']) {
          $data['status'] = true;
          $data['messages'] = $messages;
          return response()->json($data , 200);
        }else{
          $data['submessages'] = $messages;
          if ($request->type == "usermessages") {
            return view('admin.usermessages.parts.subitem',$data);
          }else{
            return view('supplier.messages.parts.subitem',$data);
          }
        }
      }else{
        $data['status'] = false;
        $data['message'] = 'record not found';
        return response()->json($data , 400);
      }
    }else{
      $data['status'] = false;
      $data['message'] = 'bad parameters check DOC file';
      return response()->json($data , 400); 
    }
  }

  public function deleteMessages($id)
  {
    $Messages = Messages::find($id);
    $end_of_chat = Messages::where(['id_from'=>$Messages->id_from,'id_to'=>$Messages->id_to,'end_of_chat'=>0])
                           ->orWhere(['id_from'=>$Messages->id_from,'id_to'=>$Messages->id_to,'end_of_chat'=>0])
                           ->orderBy('created_at','desc')
                           ->first();
    Messages::where('id',$end_of_chat->id)->update(['end_of_chat'=>1]);
    if ($Messages) {
      $data['status'] = true;
      $data['message'] = 'Request deleted succefully';
      $Messages->delete();
      return response()->json($data , 200);
    }else{
      $data['status'] = false;
      $data['message'] = 'record not found';
      return response()->json($data , 400);
    }
  }
  public function deleteConflect($order_id)
  {
    $message = Messages::where('order_id',$order_id)->get();
    if ($message) {
      $data['status'] = true;
      $data['message'] = 'Request deleted succefully';
      Messages::where('order_id',$order_id)->delete(); 
      return response()->json($data , 200);
    }else{
      $data['status'] = false;
      $data['message'] = 'record not found';
      return response()->json($data , 400);
    }
  }
}
