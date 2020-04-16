<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
   

    public function follow(Request $request){
    	$followerID = $request->followerID;
    	$followeeID = $request->followeeID;

    	$followee = User::find($followeeID);
    	// $followee->followers()->attach($followeeID);   
	    $follower = User::find($followerID);       
	    $follower->followers()->attach($followeeID);
	     return ($request['is_api'])?response()->json(true,200):redirect()->back();;
    }

    public function unFollow(Request $request){
    	$followerID = $request->followerID;
    	$followeeID = $request->followeeID;

    	$followee = User::find($followeeID);
    	// $followee->followers()->detach($followeeID);   
	    $follower = User::find($followerID);       
	    $follower->followers()->detach($followeeID);
	    return ($request['is_api'])?response()->json(true,200):redirect()->back();;
    }

    public function getFollowersNumber($userID){

    	$userOBJ = User::find($userID);
    	$userOBJ->followers;
    	return sizeof($userOBJ->followers);
    }

    public function getFollowersNumberAPI(Request $request){

    	$userID = $request->userID;
    	$userOBJ = User::find($userID);
    	$userOBJ->followers;
    	return sizeof($userOBJ->followers);
    }

    public function isFollow($followerID ,  $followeeID){
    	// $followerID = $request->followerID;
    	// $followeeID = $request->followeeID;

    	$followeeOBJ = User::find($followeeID);
    	$followeeOBJ->followers;
    	//return($followeeOBJ['followers']);

    	foreach($followeeOBJ['followers'] as $follower){
    		if($follower->id == $followerID)
    			return true;
    	}

    	return false;
    }

     public function isFollowAPI(Request $request){
    	$followerID = $request->followerID;
    	$followeeID = $request->followeeID;

    	$followeeOBJ = User::find($followeeID);
    	$followeeOBJ->followers;
    	//return($followeeOBJ['followers']);

    	foreach($followeeOBJ['followers'] as $follower){
    		if($follower->id == $followerID)
    			return true;
    	}

    	return false;
    }

    public function getFollowers($followeeID){
    	$followeeOBJ = User::find($followeeID);
    	$followeeOBJ->followers;

    	return $followeeOBJ;
    }
}
