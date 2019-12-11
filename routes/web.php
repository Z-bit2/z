<?php

use Illuminate\Http\Request;
use App\Http\Requests;

Route::get('/', function () {
    return view('home');
});

Route::get('/terms', function (){
	return view('terms');
});

Route::get('/frexawallet', function (){
	return view('frexawallet');
});

Route::get('/propertybuilder', function(Request $request){
	if($request->session()->has('seed')){
		return view('assetbuilder');
	}
	return redirect('frexawallet');
});

Route::get('/subpropertybuilder', function(Request $request){
	if($request->session()->has('seed')){
		return view('subpropertybuilder');
	}
	return redirect('frexawallet');
});

Route::post('/set_admin_token', function(Request $request){
	$request->session()->put('admin_token', $request->input('admin_token'));
	return $request->session()->get('admin_token');
});

Route::get('/propertyviewer', function(){
	return view('assetviewer');
});

Route::post('/register_user', 'Register@user_register');

Route::post('/login', 'Register@login');

Route::post('/logout', 'Register@logout');

Route::post('/send_raven', 'RPC@send_raven');

Route::post('/get_raven_amount', 'RPC@get_raven_amount');

Route::post('/get_all_assets', 'RPC@get_all_assets');

Route::post('/get_asset_details', 'RPC@get_asset_details');

Route::post('/get_my_assets', 'RPC@get_my_assets');

Route::post('/get_my_admin_assets', 'RPC@get_my_admin_assets');

Route::post('/asset_creation', 'RPC@asset_creation');

Route::post('/sub_asset_creation', 'RPC@sub_asset_creation');

Route::post('/try_send_asset', 'RPC@try_send_asset');

Route::post('/transfer_admin', 'RPC@transfer_admin');

Route::post('/get_ipfs', 'PIpfs@get_ipfs');

Route::post('/get_details_of_specific', 'RPC@get_details_of_specific');

Route::post('/try_reissue', 'RPC@try_reissue');

Route::post('test', function () {
    event(new App\Events\StatusWalletChanged("aa", 100));
    return "Event has been sent!";
});

Route::post('/ajax_upload/action', 'AjaxUploadController@action')->name('image_upload.action');

Route::post('/test_raven_net', 'CustomRPC@user_register');