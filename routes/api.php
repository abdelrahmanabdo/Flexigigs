<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
// system status guide
      Route::post('change/type/{type}', [
        'uses' => 'HomeController@changeType'
      ]);
      Route::post('/system_guide', [
        'uses' => 'HomeController@system_guide'
      ]);
//////// *****  services APIs **** \\\\\\\\\\\\\\

      Route::post('/services', [
        'uses' => 'ServicesController@addService'
      ]);
      Route::get('/getService/{id}', [
        'uses' => 'ServicesController@getService'
      ]);
      Route::get('/filterservices', [
        'uses' => 'ServicesController@filterServices'
      ]);//->middleware('auth:api');
      Route::get('filterservicestest', [
        'uses' => 'ServicesController@filterServices'
      ])->middleware('client');
      Route::post('/services/addimage/{id}', [
        'uses' => 'ServicesController@addserviceimage'
      ]);
      Route::post('/services/edit/{id}', [
        'uses' => 'ServicesController@update_service'
      ]);
      Route::get('/services', [
        'uses' => 'ServicesController@getServices'
      ]);
      Route::delete('/services/{id}', [
        'uses' => 'ServicesController@deleteService'
      ]);
      Route::delete('/servicesimg/{id}', [
        'uses' => 'ServicesController@deleteServiceImage'
      ]);
      Route::delete('/servicesvideo/{id}', [
        'uses' => 'ServicesController@deleteServiceVideo'
      ]);
      Route::delete('/serviceslocation/{id}', [
        'uses' => 'ServicesController@deleteServiceLocation'
      ]);
      Route::get('/filter_data', [
        'uses' => 'ServicesController@filter_data'
      ]);

//////// ***** End of services APIs **** \\\\\\\\\\\\\\


/*Follow API*/ 
      Route::get('/follow', [
            'uses' => 'FollowController@follow'
          ]);
      Route::get('/unFollow', [
            'uses' => 'FollowController@unFollow'
          ]);
      Route::get('/isFollowAPI', [
            'uses' => 'FollowController@isFollowAPI'
          ]);
      Route::get('/getFollowersNumberAPI', [
            'uses' => 'FollowController@getFollowersNumberAPI'
          ]);
/***********/

//////// *****  Categories APIs **** \\\\\\\\\\\\\\

      Route::get('getcategory/{id}', [
        'uses' => 'CategoriesController@getCategory'
      ]);
      // ->middleware('auth:api');
      // ->middleware('client');
      Route::post('category', [
        'uses' => 'CategoriesController@addCategory'
      ]);
      Route::post('category/edit', [
        'uses' => 'CategoriesController@updateCategory'
      ]);
      Route::delete('category/{id}', [
        'uses' => 'CategoriesController@deleteCategory'
      ]);
      Route::get('getparents', [
        'uses' => 'CategoriesController@getParents'
      ]);
      Route::get('keyskills', [
        'uses' => 'CategoriesController@keyskills'
      ]);
      Route::get('/getchildren', [
        'uses' => 'CategoriesController@getChildren'
      ]);
      Route::get('/getfeatured', [
        'uses' => 'CategoriesController@getFeatured'
      ]);
      Route::post('/filtercategory', [
        'uses' => 'CategoriesController@filterCategory'
      ]);

//////// *****  End of Categories APIs **** \\\\\\\\\\\\\\

//////// *****  Users APIs **** \\\\\\\\\\\\\\
      // regestration
      Route::post('/registration', [
        'uses' => 'UsersController@registration'
      ]);
      Route::post('/regimage', [
        'uses' => 'UsersController@regimage'
      ]);
      Route::post('/facebook_reg', [
        'uses' => 'UsersController@FBregistration'
      ]);
      Route::post('/facebook_reg2', [
        'uses' => 'UsersController@FBregistration2'
      ]);
      // end of regestration
      // login
      Route::post('/login', [
        'uses' => 'UsersController@login'
      ]);
      Route::post('/logout', [
        'uses' => 'UsersController@logout'
      ]);
      Route::post('/forget_password', [
        'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
      ]); 
      // sendResetLinkEmail
      Route::post('/facebook_login', [
        'uses' => 'UsersController@FBlogin'
      ]);     
      // end of login
      Route::get('/varify', [
        'uses' => 'UsersController@active'
      ]);
      Route::get('/pending', [
        'uses' => 'UsersController@pending'
      ]);
      Route::post('/profile', [
        'uses' => 'UsersController@profile'
      ]);
      Route::post('/bank', [
        'uses' => 'SupplierController@bank'
      ]);
      Route::delete('/user/{id}', [
        'uses' => 'UsersController@deleteUser'
      ]);
      Route::get('revarify/{id}', 'Auth\RegisterController@resendVarification');

      Route::get('/user/{id}', [
        'uses' => 'UsersController@getUser'
      ]);
      Route::post('/getusers', [
        'uses' => 'UsersController@getUsers'
      ]);
      Route::get('/getusers', [
        'uses' => 'UsersController@getUsers'
      ]);
      Route::get('/exportusers', [
        'uses' => 'UsersController@exportusers'
      ]);
      Route::post('/user_validator', [
        'uses' => 'UsersController@field_validator'
      ]);
      Route::post('password/email', 'Auth\ForgotPasswordController@getResetToken');
      Route::post('password/reset', 'Auth\ResetPasswordController@reset');
      Route::post('change_lang','UsersController@change_lang');

//////// *****  End of Users APIs **** \\\\\\\\\\\\\\
//////// *****  role APIs **** \\\\\\\\\\\\\\
      Route::get('/getroles', [
        'uses' => 'roleController@getRoles'
      ]);
      Route::get('/getrole/{id}', [
        'uses' => 'roleController@getRole'
      ]);
      Route::post('/addrole', [
        'uses' => 'roleController@addRole'
      ]);
      Route::put('/editrole', [
        'uses' => 'roleController@editRole'
      ]);
      Route::delete('/role/{id}', [
        'uses' => 'roleController@deleteRole'
      ]);
      Route::delete('/getbackrole/{id}', [
        'uses' => 'roleController@getBackRole'
      ]);
//////// *****  End of role APIs **** \\\\\\\\\\\\\\

//////// *****  Permissions APIs **** \\\\\\\\\\\\\\
      Route::get('/allpermissions', [
        'uses' => 'PermissionsController@allPermissions'
      ]);
      Route::get('/getpermissions/{id}', [
        'uses' => 'PermissionsController@getRolePermissions'
      ]);
      Route::get('/allpermissionsfor/{id}',[
        'uses'=> 'PermissionsController@allPermissionsFor'
      ]);
      Route::post('/addpermissionsrole', [
        'uses' => 'PermissionsController@addPermissionsRole'
      ]);
//////// *****  End of Permissions APIs **** \\\\\\\\\\\\\\
//////// *****  Favorite APIs **** \\\\\\\\\\\\\\

      Route::post('/favorite', [
        'uses' => 'FavoriteController@addFavorite'
      ]);
      Route::get('/favorite/{id}', [
        'uses' => 'FavoriteController@getFavorite'
      ]);
      Route::post('/deletefavorite', [
        'uses' => 'FavoriteController@deleteFavorite'
      ]);

//////// *****  End of Favorite APIs **** \\\\\\\\\\\\\\
//////// *****  Messages APIs **** \\\\\\\\\\\\\\

      Route::post('messages/conflects/{id}',[
        'uses' => 'MessagesController@conflects'
      ]);
      Route::post('/mymessages/{id}', [
        'uses' => 'MessagesController@myMessages'
      ]);
      Route::post('usermessages', [
        'uses' => 'AdminController@usermessages'
      ]);
      Route::post('/sendmessages', [
        'uses' => 'MessagesController@sendMessages'
      ]);
      Route::post('/messagewith', [
        'uses' => 'MessagesController@messageWith'
      ]);      
      Route::delete('/conflect/{order_id}', [
        'uses' => 'MessagesController@deleteConflect'
      ]);
      Route::delete('message/delete/{id}', [
        'uses' => 'MessagesController@deleteMessages'
      ]);
    
//////// *****  End of Messages APIs **** \\\\\\\\\\\\\\
//////// *****  gigs APIs **** \\\\\\\\\\\\\\
      Route::get('getgig/{id}',[
        'uses'=>'GigsController@getGig'
      ]);
      Route::get('gigs/filter_data', [
        'uses' => 'GigsController@filter_data'
      ]);
      Route::get('gigs/filter', [
        'uses' => 'GigsController@filter'
      ]);
      Route::post('/gigs', [
        'uses' => 'GigsController@store'
      ]);
      Route::post('/gigcancel/{id}', [
        'uses' => 'GigsController@gigStatus'
      ]);
      Route::post('/gigattach/{id}', [
        'uses' => 'GigsController@addgigattachment'
      ]);    
//////// ***** End of gigs APIs **** \\\\\\\\\\\\\\
//////// *****  Request APIs **** \\\\\\\\\\\\\\
      Route::get('request/service/{id}',[
        'uses'=>'RequestsController@requestService'
      ]);
      Route::post('request/service/{id}',[
        'uses'=>'RequestsController@requestService'
      ]);
      Route::get('request/callback', [
        'uses'=>'RequestsController@requestReturn'
      ]);
      Route::post('request/callback/{id}', [
        'uses'=>'RequestsController@requestReturn'
      ]);
//////// ***** End of Request APIs **** \\\\\\\\\\\\\\
//////// *****  Application APIs **** \\\\\\\\\\\\\\
    
    Route::get('application/{id}',[
        'uses'=>'ApplicationController@getApplication'
    ]);
    Route::post('application/create/{id}',[
        'uses'=>'GigsController@getGig'
    ]);
    Route::delete('application/delete/{id}',[
      'uses'=>'ApplicationController@delete'
    ]);

//////// ***** End of Application APIs **** \\\\\\\\\\\\\\
//////// ***** Orders APIs **** \\\\\\\\\\\\\\
    Route::post('orders/list',[
        'uses'=>'OrdersController@orders'
    ]);
    Route::post('refund/list',[
        'uses'=>'CustomerController@refund'
    ]);
    Route::post('orders/status/{id}',[
        'uses'=>'OrdersController@orderStatus'
    ]);
    Route::post('orders/mass_paid',[
        'uses'=>'OrdersController@mass_paid'
    ]);
    Route::post('orders/reject/{id}',[
        'uses'=>'OrdersController@orderRejection'
    ]);
    Route::post('orders/extend/{id}',[
        'uses'=>'OrdersController@orderExtendDeadline'
    ]);
    Route::post('orders/refund/{id}',[
        'uses'=>'OrdersController@claim_refund'
    ]);
    Route::get('orders/single/{id}',[
        'uses'=>'OrdersController@single'
    ]);
    Route::get('orders/byitemid/{item_id}',[
        'uses'=>'OrdersController@OrderByItemId'
    ]);
//////// ***** End of Orders APIs **** \\\\\\\\\\\\\\
//////// *****  Supplier APIs **** \\\\\\\\\\\\\\
    Route::post('supplier/mygigs',[
        'uses'=>'SupplierController@gigs'
    ]);
    Route::post('supplier/myapplications',[
        'uses'=>'SupplierController@application'
    ]);
    Route::post('supplier/myservices',[
        'uses'=>'SupplierController@services'
    ]);
    Route::post('supplier/myearnings',[
        'uses'=>'SupplierController@earnings'
    ]);
    Route::get('supplier/earning_details/{id}',[
        'uses'=>'SupplierController@earning_details'
    ]);
//////// ***** End of Supplier APIs **** \\\\\\\\\\\\\\
//////// *****  Customer APIs **** \\\\\\\\\\\\\\
    Route::post('customer/orders',[
        'uses'=>'CustomerController@orders'
    ]);
    Route::post('customer/posts',[
        'uses'=>'CustomerController@posts'
    ]);
    Route::post('customer/myservices',[
        'uses'=>'CustomerController@services'
    ]);
//////// ***** End of Customer APIs **** \\\\\\\\\\\\\\
//////// *****  Review APIs **** \\\\\\\\\\\\\\
    Route::get('review/list',[
        'uses'=>'ReviewsController@reviews'
    ]);
    Route::post('review/add/{id}',[
        'uses'=>'ReviewsController@add'
    ]);
    Route::post('review/edit/{id}',[
        'uses'=>'ReviewsController@edit'
    ]);
    Route::delete('review/delete/{id}',[
        'uses'=>'ReviewsController@delete'
    ]);
//////// ***** End of Review APIs **** \\\\\\\\\\\\\\
//////// *****  Admin APIs **** \\\\\\\\\\\\\\
    Route::post('admin/myearnings',[
        'uses'=>'AdminController@earnings'
    ]);
//////// ***** End of Admin APIs **** \\\\\\\\\\\\\\
//////// *****  Page APIs **** \\\\\\\\\\\\\\
    Route::get('page/faq',[
        'uses'=>'PageController@faq'
    ]);
    Route::get('page/terms',[
        'uses'=>'PageController@terms'
    ]);
    Route::get('page/privacy',[
        'uses'=>'PageController@privacy'
    ]);
    Route::get('page/refund',[
        'uses'=>'PageController@refund'
    ]);
    Route::get('page/howitwork',[
        'uses'=>'PageController@howItWork'
    ]);
    Route::post('page/contactus',[
        'uses'=>'PageController@contactus'
    ]);
    
//////// ***** End of Page APIs **** \\\\\\\\\\\\\\
//////// *****  Profile APIs **** \\\\\\\\\\\\\\
    Route::get('profile/supplier/{username}',[
        'uses'=>'ProfileController@supplier'
    ]);
    Route::get('profile/customer/{username}',[
        'uses'=>'ProfileController@customer'
    ]);
    Route::get('reviews/supplier/{username}',[
        'uses'=>'ProfileController@ghreviews'
    ]);

//////// ***** End of Page APIs **** \\\\\\\\\\\\\\