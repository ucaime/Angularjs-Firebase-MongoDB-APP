<?php

/**
  * AuthController API class
  *
  * This class handle all auth requests, processes registration and login form 
  * requests and return user profile
  *
  * @author  	Sardor Isakov
  * @package	AuthController
  * @param 		void
  * @return 	void
  */
class AuthController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Auth Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@logout'))->before('auth');
	| 	Route::post('login', 'AuthController@login');
	| 	Route::post('register', 'AuthController@register');
	| 	Route::get('register', array('as'=>'register_form', 'uses' => 'AuthController@register_form'))->before('guest');
	| 	Route::get('login', array('as' => 'login', 'uses' => 'AuthController@index'))->before('guest');
	| 	Route::get('profile', array('as' => 'profile', 'uses' => 'AuthController@profile'))->before('auth');
	|
	*/
	/**
	 * Constructer function
	 * @return  void
	 */
	public function __construct() {
        //$this->beforeFilter('auth');
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return void
	 */
	public function index() {
		// Return index page
		return View::make('account.login');
	}

	/**
	 * Login API, authenticates user
	 *
	 * This function accepts POST request to example.com/login URL 
	 * and it authenticates login info
	 *
	 * @method 	POST
	 * @param 	array 	$formData 	Parameter is form data for authentication
	 *						 		 $email    => user provided email
	 *								 $password => user provided password
	 * @return  array 	$result 	It will return json result
	 */
	public function login() {
		$user = array(
			'email' => Input::get('email'), 
			'password' => Input::get('password') 
		);

		if(Auth::attempt($user)) {
    		// $posts = Post::get_posts();
    		// return View::make('hello')->with('posts',$posts);
    		return Redirect::to('account')
    			->with('flash_notice', 'You are successfully logged in');
	    } 

	    return Redirect::to('login')
            ->with('flash_error', 'Your username/password combination was incorrect.')
            ->withInput();
	}

	/**
	 * logout user
	 *
	 * This function accepts GET request to example.com/logout URL 
	 * and it logout user
	 *
	 * @method 	GET
	 * @param 	array 	_COOKIE		
	 * @return  array 	$result 	It will return json result
	 */
	public function logout() {
		Auth::logout();
    	return Redirect::route('home')
        	->with('flash_notice', 'You are successfully logged out.');
	}

	/**
	 * Get profile API, it displays user ID
	 *
	 * This function accepts GET
	 *
	 * @method 	GET
	 * @return  array 	$result 	It will return json result
	 */
	public function profile() {
		$user = LMongo::collection('users')->where('_id', new MongoId(Auth::user()->id) )->first();
		return Response::json($user);
	}

	/**
	 * Register API, form processing
	 *
	 * This function accepts POST request to example.com/register URL 
	 * and it processes form data for registration
	 *
	 * @method 	POST
	 * @param 	array 	$formData 	Parameter is form data for regsitration
	 *						 		$email    => user provided email
	 *								$password => user provided password
	 * @return  array 	$result 	It will return json result
	 */
	public function register() {

		$validator = User::validate(Input::all());

		if ($validator->passes()) {
			$user = User::create(array(
				'email'    => Input::get('email'),
				'password' => Hash::make(Input::get('password')),
				'avatar' => '/img/images.jpg'
			));
			//var_dump($ss);
			if($user) {
				Auth::attempt(array(
					'email'    => Input::get('email'),
					'password' => Input::get('password')
				));
	    		// $posts = Post::get_posts();
	    		// return View::make('hello')->with('posts',$posts);
	    		return Redirect::to('account')
	    			->with('flash_notice', 'You are successfully registered');
		    } 
	    } else {
	    	//$messages = $validator->messages()->first('email');
	    	return Redirect::to('register')->withErrors($validator->messages());
	    	//return Redirect::to('register')->with($p);
	    }
	}





	public function upload() {
		$file = Input::file('image');

 
		$destinationPath = 'uploads/';

		$filename = $file->getClientOriginalName();
		//$extension =$file->getClientOriginalExtension(); 
		$upload_success = Input::file('image')->move($destinationPath, $filename);
		 
		if( $upload_success ) {
			$ad = array(
				'avatar' => 'http://purecss.io/img/common/tilo-avatar.png',
			);


			$id = LMongo::collection('users')
                ->where('_id', new MongoId( Auth::user()->id ))
                ->update($ad);

		   return Response::json('success', 200);
		} else {
		   return Response::json('error', 400);
		}

       
        	


    }





	public function register_form() {
		return View::make('account.register');
	}

	public function post_upload(){
		return "Goog";
 
	    $input = Input::all();
	    $rules = array(
	        'file' => 'image|max:3000',
	    );
	 
	    $validation = Validator::make($input, $rules);
	 
	    if ($validation->fails())
	    {
	        return Response::make($validation->errors->first(), 400);
	    }
	 
	    $file = Input::file('file');
	 
	    $extension = File::extension($file['name']);
	    $directory = path('public').'uploads/'.sha1(time());
	    $filename = sha1(time().time()).".{$extension}";
	 
	    $upload_success = Input::upload('file', $directory, $filename);
	 
	    if( $upload_success ) {
	        return Response::json('success', 200);
	    } else {
	        return Response::json('error', 400);
	    }
	}

}