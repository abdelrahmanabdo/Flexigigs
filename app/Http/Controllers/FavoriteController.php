<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service;
use App\User;
use App\Favorite;
use App\Helpers\Flexihelp;
use App\ServicePhoto;
class FavoriteController extends Controller
{
     public function getFavorite(Request $request , $id) {
       $page_num = ($request->page_num)?$request->page_num:0;
       $limit = ($request->limit)?$request->limit:5;
       $favorites = Favorite::where('user_id', $id)
                            ->with(['service.photos','service.videos','service.user'])
                            ->paginate($limit);
        foreach ($favorites as $favorite) {
          if ($favorite->service) {
            $favorite->service->rate = Flexihelp::get_stars('service',$favorite->service->id,true);
          }
        }                            
       if ($favorites) {
         $data['status'] = true;
         $data['list'] = $favorites;
         return response()->json($data , 200);
       }
     }
    public function addFavorite(Request $request)
      {
        if ($request->user_id &&$request->service_id) {
          $favorite_check = Favorite::where([['user_id',$request->user_id],['service_id',$request->service_id]])->first();
          if($favorite_check){
            $data['status'] = false;
            $data['message'] = 'service already in your favorites list ';
            return response()->json($data , 200);
          }else{
            $favorite = new Favorite;
            $favorite->user_id = $request->user_id;
            $favorite->service_id = $request->service_id;
            $favorite->save();
            $data['status'] = true;
            $data['message'] = 'added with success';
            $data['list'] = $favorite;
            return response()->json($data , 201);
          }
        }else{
          $data['status'] = false;
          $data['message'] = 'bad parameters check DOC file';
          return response()->json($data , 400);
        }
      }
    public function deleteFavorite(Request $request)
      {
        if ($request->user_id&&$request->service_id) {
          $favorite_check = Favorite::where([['user_id',$request->user_id],['service_id',$request->service_id]])->first();
          if ($favorite_check) {
            $deleteres = Favorite::where([['user_id','=',$request->user_id],['service_id','=',$request->service_id]])->delete();
            $data['status'] =true;
            $data['message'] = 'Record deleted succefully';
            $data['delete'] = $favorite_check;
            return response()->json($data , 200);
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
}
