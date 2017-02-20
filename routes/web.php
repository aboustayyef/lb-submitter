<?php

use Illuminate\Http\Request;

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

// login with socialte
Route::get('login/twitter', 'Auth\LoginController@redirectToProvider');
Route::get('login/twitter/callback', 'Auth\LoginController@handleProviderCallback');
//

Route::get('/', function () {
    
    return view('home');

});

Route::post('/', function(Request $request){
	return $request->all();
});

Route::get('/api/urlDetails', function(Request $request){

	$response= new App\UrlAnalyzer($request->get('url'));
	return response()->json($response);

});


Route::get('/api/feedDetails', function(Request $request){

	$response= new App\FeedFetcher($request->get('url'));
	return response()->json($response);

});

Route::get('/api/twitterDetails', function(Request $request){

	$response = new App\TwitterGetter($request->get('username'));
	return response()->json($response);

});

Route::get('/api/usernameExists', function (Request $request){
	
	$response = new stdClass;
	try {
		$exists = \App\Blog::where('blog_id', $request->get('blogId'))->count() > 0;
		$response->status = 'ok';
		$response->result = $exists;
	} catch (\Exception $e) {
		$response->status = 'error';
		$response->result = null;
	}
	return response()->json($response);

});