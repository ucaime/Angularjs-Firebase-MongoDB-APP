<?php
Blade::setContentTags('<%', '%>'); 		// for variables and all things Blade
Blade::setEscapedContentTags('<%%', '%%>'); 	// for escaped data
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Home Controller
|--------------------------------------------------------------------------
*/
Route::get('/', 'HomeController@index');

/*
|--------------------------------------------------------------------------
| Account API Controller
|--------------------------------------------------------------------------
*/
Route::post('/account/ads', 'AccountController@store');

Route::get('/account/ads', 'AccountController@index');
Route::get('/account/ads/{id}', 'AccountController@show');
Route::put('/account/ads/{id}', 'AccountController@update');
Route::get('account', array('as' => 'home', function() {
	return View::make('ads.index');
}))->before('auth');


/*
|--------------------------------------------------------------------------
| Auth Controller
|--------------------------------------------------------------------------
*/
Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@logout'))->before('auth');
Route::post('login', 'AuthController@login');
Route::post('upload/avatar', 'AuthController@upload');
Route::post('register', 'AuthController@register');
Route::get('register', array('as'=>'register_form', 'uses' => 'AuthController@register_form'))->before('guest');
Route::get('login', array('as' => 'login', 'uses' => 'AuthController@index'))->before('guest');
Route::get('profile', array('as' => 'profile', 'uses' => 'AuthController@profile'))->before('auth');

/*
|--------------------------------------------------------------------------
| Contacts API Controller
|--------------------------------------------------------------------------
*/
Route::resource('contact', 'ContactsController');

Route::get('/item/{id}', function($id) {
	//$value = Cache::get($id);
    //if (empty($value)) {
		$value = LMongo::collection('ads')->where('_id', new MongoId($id))->first();
		$minutes = 200;
		//Cache::put($id, $value, $minutes);
	//}
	return View::make('item', array('ad' => $value, 'user_name' => 'Sardor I'));
});

/*
|--------------------------------------------------------------------------
| Image Upload API Controller
|--------------------------------------------------------------------------
*/
Route::get('upload_image', function() {
	return View::make('upload');
});

Route::post('api/upload', function() {
		$file = Input::file('image');


		$destinationPath = 'uploads/'.str_random(8);

		$filename = $file->getClientOriginalName();
		$upload_success = Input::file('image')->move($destinationPath, $filename);
		 
		if( $upload_success ) {
			$avatar = array(
				'avatar' => '/'.$destinationPath.'/'.$filename,
			);
			//var_dump($avatar);die();


			$id = LMongo::collection('users')
                ->where('_id', new MongoId( Auth::user()->id ))
                ->update($avatar);

            $arrayName = array(
            	'success' => 200, 
            	'avatar'=> $avatar['avatar']
            );

            $id = LMongo::collection('ads')
                ->where('user_id', Auth::user()->id)
                ->update($avatar);

            $id = LMongo::collection('comments')
                ->where('user_id', Auth::user()->id)
                ->update($avatar);

		   return Response::json($arrayName);
		} else {
		   return Response::json('error', 400);
		}
});

/*
|--------------------------------------------------------------------------
| Comments API Controller
|--------------------------------------------------------------------------
*/
Route::get('/item/{id}/comments', function($id) {
	$item_id = $id;

    $comments = LMongo::collection('comments')->where('item_id', $item_id)->get();
    $result = array();
    foreach ($comments as $key => $value) 
        array_push($result, $value);

	return Response::json(array('success' => 200, 'data' => $result ));
});

Route::post('api/comments', function( ) {
	$user = LMongo::collection('users')->where('_id', new MongoId(Auth::user()->id) )->first();

	$epocha = time() . '000';
	$input = array(
        'user_id' 	=> Auth::user()->id,
        'timestamp' => $epocha,
        'item_id' 	=> Input::get('item_id'),
        'comment' 	=> Input::get('comment'),
        'avatar' 	=> $user['avatar']
    );
    $id = LMongo::collection('comments')->insert($input)->{'$id'};
    $comment = LMongo::collection('comments')->where('_id', new MongoId($id) )->first();

	return Response::json(array('success' => 200, 'data' => $comment));
})->before('auth');




