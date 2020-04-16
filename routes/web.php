<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// auth
// Route::middleware('web')->group(function () {
// });
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/apple-app-site-association', 'HomeController@applejson');
Route::get('home', 'HomeController@index');
Route::get('contact-us', 'PageController@contactus')->name('contact-us');
Route::post('contact-us', 'PageController@contactus');
Route::get('faq', 'PageController@faq')->name('faq');
Route::get('terms', 'PageController@terms')->name('terms');
Route::get('privacy-policy', 'PageController@privacy')->name('privacy-policy');
Route::get('refund-policy', 'PageController@refund')->name('refund-policy');
Route::get('how-it-work', 'PageController@howItWork')->name('how-it-work');

Route::get('searchSingle', 'SupplierController@searchSingle')->name('searchSingle');
Route::get('searchList', 'SupplierController@searchList')->name('searchList');


/*follow routes by Osman*/
Route::get('follow', 'FollowController@follow')->name('follow');
Route::get('unFollow', 'FollowController@unFollow')->name('unFollow');
Route::get('getFollowers', 'FollowController@getFollowersNumber')->name('getFollowersNumber');
Route::get('isFollow', 'FollowController@isFollow')->name('isFollow');
Route::get('isFollowAPI', 'FollowController@isFollowAPI')->name('isFollowAPI');
Route::get('getFollowersAPI', 'FollowController@getFollowersAPI')->name('getFollowersAPI');
Route::get('getFollowers', 'FollowController@getFollowers')->name('getFollowers');


Route::get('switch/to/{member_type}', 'HomeController@changeType')->name('switch');
Route::get('login/facebook/callback', 'Auth\RegisterController@handleProviderCallback');
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('revarify/{id}', 'Auth\RegisterController@resendVarification')->name('revarify');
Route::get('/varify/{id}','UsersController@varify')->name('varify');
Route::get('search/{type}', 'HomeController@search')->name('search');

// groups

Route::middleware('role:admin')->group(function () {
// admin
	Route::get('admin/dashboard', 'AdminController@dashboard');
	Route::get('admin/profile/edit', 'AdminController@editProfile')->name('admin_profile');
	Route::post('admin/profile/edit', 'AdminController@editProfile');
	// user
	Route::get('admin/users/varify', ['uses' => 'UsersController@active']);
	Route::get('admin/users/pending', ['uses' => 'UsersController@pending']);
	Route::get('admin/dashboard/users', 'UsersController@getUsers')->name('admin_users');
	Route::get('admin/users/edit/{id}', 'AdminController@profile')->name('admin_edituser');
	Route::post('admin/users/edit/{id}', 'AdminController@profile');
	Route::get('admin/users/download', 'UsersController@exportusers')->name('downloadusers');
	Route::get('admin/service/download', 'ServicesController@exportservice')->name('exportservice');
	Route::get('admin/gig/download', 'GigsController@exportgig')->name('exportgig');
	Route::get('admin/order/download', 'OrdersController@exportorder')->name('exportorder');
	// end user
	// service
	Route::get('admin/dashboard/services', 'AdminController@filterServices')->name('admin_services');
	Route::post('admin/addservice','ServicesController@addservice');
	// end service
	// orders
	Route::get('admin/dashboard/orders', 'AdminController@orders')->name('admin_orders');
	// end orders
	// gigs
	Route::get('admin/dashboard/gigs', 'AdminController@gigs')->name('admin_gigs');
	// end gigs
	// earnings
	Route::get('admin/dashboard/earnings', 'AdminController@earnings')->name('admin_earnings');
	// earnings
	// refund
	Route::get('admin/dashboard/refund', 'AdminController@refund')->name('admin_refund');
	// end refund
	// category
	Route::get('admin/categories', 'AdminController@categories')->name('admin_categories');
	Route::post('admin/add/categories', 'AdminController@addcategory')->name('add_category');
	Route::post('admin/edit/categories', 'AdminController@editcategory')->name('edit_category');
	// end category
	// message
	Route::get('admin/dashboard/reviews', 'AdminController@reviews')->name('admin_reviews');
	Route::get('admin/dashboard/usermessages', 'AdminController@usermessages')->name('admin_usermessages');
	Route::get('admin/dashboard/messages/conflects', 'AdminController@conflects_messages')->name('admin_messages');
	Route::get('admin/dashboard/messages/direct', 'AdminController@direct_messages')->name('admin_directmessages');
	Route::post('admin/conflects/{id}', 'MessagesController@conflects')->name('admin_mymessages');
	Route::post('admin/messagewith', 'MessagesController@messageWith')->name('admin_messagewith');
	Route::post('admin/sendmessage', 'MessagesController@sendMessages')->name('admin_sendmessage');
	Route::delete('/conflect/{order_id}', ['uses' => 'MessagesController@deleteConflect']);
	// end message
	Route::post('admin/usermessages', 'AdminController@usermessages')->name('usermessages');
	Route::delete('message/delete/{id}', ['uses' => 'MessagesController@deleteMessages']);
	Route::post('admin/refund/changeToRefund', 'AdminController@changeToRefund')->name('changeToRefund');

});
Route::middleware('auth')->group(function () {
	// favorite
	Route::post('favorite/add', 'FavoriteController@addFavorite')->name('add_favorite');
	Route::post('favorite/delete', 'FavoriteController@deleteFavorite')->name('delete_favorite');
	// customer
	
	Route::get('customer/profile/edit', 'CustomerController@editProfile')->name('hh_edit_profile');
	Route::post('customer/profile/edit', 'CustomerController@editProfile');
	Route::post('customer/mymessages/{id}', 'MessagesController@myMessages')->name('customer_mymessages');
	Route::post('customer/messagewith', 'MessagesController@messageWith')->name('customer_messagewith');
	Route::post('customer/sendmessage', 'MessagesController@sendMessages')->name('customer_sendmessage');
	Route::get('customer/dashboard', function () {
    	return redirect('customer/dashboard/orders');
			})->name('customer_dashboard');
	Route::get('customer/dashboard/refund','CustomerController@refund')->name('customer_refund');
	Route::get('customer/dashboard/orders','CustomerController@orders')->name('customer_orders');
	Route::get('customer/dashboard/posts','CustomerController@posts')->name('customer_posts');
	Route::get('customer/dashboard/favorites','CustomerController@favorites')->name('customer_favorites');
	Route::get('customer/dashboard/messages','CustomerController@messages')->name('customer_messages');
	// supplier

	// Route::get('supplier/profile/delete/{id}', 'UsersController@deleteUser');
	Route::get('supplier/profile/edit', 'SupplierController@editProfile')->name('gh_edit_profile');
	Route::post('supplier/profile/edit', 'SupplierController@editProfile');
	Route::get('supplier/payment/to/{method}', 'SupplierController@cashout')->name('cashout');
	Route::get('supplier/dashboard', function () {
    	return redirect('supplier/dashboard/gigs');
			})->name('supplier_dashboard');
	Route::get('supplier/dashboard/services', 'SupplierController@services')->name('supplier_services');
	Route::get('supplier/dashboard/messages', 'SupplierController@messages')->name('supplier_messages');
	Route::get('supplier/dashboard/gigs', 'SupplierController@gigs')->name('supplier_gigs');
	Route::get('supplier/dashboard/applications', 'SupplierController@application')->name('supplier_application');
	Route::get('supplier/dashboard/earnings', 'SupplierController@earnings')->name('supplier_earnings');
	Route::get('supplier/dashboard/bank', 'SupplierController@bank')->name('supplier_bank');
	Route::post('supplier/dashboard/bank', 'SupplierController@bank')->name('supplier_bank');
	Route::post('supplier/addservice','SupplierController@addservice')->name('add_service');
	Route::post('supplier/update_service/{id}', 'SupplierController@update_service')->name('update_service');
	Route::post('supplier/mymessages/{id}', 'MessagesController@myMessages')->name('mymessages');
	Route::post('supplier/messagewith', 'MessagesController@messageWith')->name('messagewith');
	Route::post('supplier/sendmessage', 'MessagesController@sendMessages')->name('sendmessage');
	
	// Gigs
	Route::post('gigs/store','GigsController@store')->name('add_gig');
	Route::post('/gigcancel/{id}', ['uses' => 'GigsController@gigStatus']);
	// Request services
	Route::get('request/service/payment/{order_id}', 'RequestsController@proceed_to_payment')->name('proceed_to_payment');
	Route::get('request/service/{id}','RequestsController@requestService')->name('request');
	Route::post('request/service/{id}','RequestsController@requestService')->name('add_request');
	Route::get('request/service/callback/{order_id}', 'RequestsController@requestCallback')->name('request_callback');
	Route::get('request/service/payment_callback/{order_id}', 'RequestsController@requestReturn')->name('payment_callback');
	// application
	Route::get('application/{id}', 'ApplicationController@getApplication');
	Route::get('application/checkout/callback', 'ApplicationController@callback')->name('applicationReturn');
	Route::get('application/checkout/{id}', 'ApplicationController@checkout');
	Route::post('application/checkout/{id}', 'ApplicationController@checkout');
		// callback
 	Route::post('orders/status/{id}',['uses'=>'OrdersController@orderStatus']);
 	Route::post('orders/mass_paid','OrdersController@mass_paid')->name("mass_paid");
	Route::delete('review/delete/{id}',['uses'=>'ReviewsController@delete']);
	Route::delete('/servicesimg/{id}', ['uses' => 'ServicesController@deleteServiceImage']);
	Route::delete('/services/{id}', ['uses' => 'ServicesController@deleteService']);
	Route::delete('application/delete/{id}',['uses'=>'ApplicationController@delete']);
	
	Route::post('review/edit/{id}',['uses'=>'ReviewsController@edit']); 
 });
// mobile
Route::get('mobile/request/service', 'RequestsController@requestReturn')->name('mobilerequestReturn');
Route::get('mobile/request/service/{id}','RequestsController@requestService')->name('mobileadd_request');
Route::get('mobile/application/checkout/callback', 'ApplicationController@callback')->name('mobileapplicationReturn');
Route::get('mobile/application/checkout/{id}',[
    'uses'=>'ApplicationController@checkout'
]);


// supplier
Route::get('supplier/profile/{username}', 'ProfileController@supplier')->name('supplier_profile');
Route::get('supplier/reviews/{username}', 'ProfileController@ghreviews')->name('supplier_reviews');
// customer
Route::get('customer/reviews/{username}', 'ProfileController@customer')->name('customer_profile');
// categories 
// request 
Route::get('/categories/filterCategory', 'CategoriesController@filterCategory');
Route::post('category/dependancy', 'CategoriesController@dependancy')->name('dependancy');

// gigs
Route::get('gigs', 'GigsController@filter')->name('gigs');
Route::get('gig/details/{id}', 'GigsController@getGig')->name('gig_details');
Route::post('gig/details/{id}', 'GigsController@getGig');
Route::get('gig/categories', 'CategoriesController@getParents')->name('gigs_categories');
Route::get('gig/category/{slug}', 'GigsController@filter')->name('gig_list');
Route::get('gig/{category}', 'CategoriesController@getCategory')->name('gig_subcategory');
Route::get('gig/{category}/{slug}', 'CategoriesController@getCategory')->name('gig_subcategory2');
Route::get('gig/{parentcategory}/{category}/{slug}', 'CategoriesController@getCategory')->name('gig_subcategory3');

Route::get('service/categories', 'CategoriesController@getParents')->name('service_categories');
Route::get('service/category/{slug}', 'ServicesController@filterServices')->name('service_list');
Route::get('service/details/{id}', 'ServicesController@getService')->name('service_details');
Route::get('service/{category}', 'CategoriesController@getCategory')->name('service_subcategory');
Route::get('service/{category}/{slug}', 'CategoriesController@getCategory')->name('service_subcategory2');
Route::get('service/{parentcategory}/{category}/{slug}', 'CategoriesController@getCategory')->name('service_subcategory3');