<?php

/**
  * AccountController API class
  *
  * This class handle all auth requests, processes registration and login form 
  * requests and return user profile
  *
  * @author  	Sardor Isakov
  * @package	AuthController
  * @param 		void
  * @return 	void
  */
class AccountController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Account Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'AccountController@showWelcome');
	|
	*/
	 /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
    	$value = Cache::get($id);
    	if ($value) {
    		 return $value;
		} else {
		 	 $value = LMongo::collection('ads')->where('_id', new MongoId($id))->first();
			 $minutes = 200;
			 Cache::put($id, $value, $minutes);
			 //$value = Cache::get('key');
		 	 return $value;
		}

        // if (Request::ajax()) {
        //     $user = LMongo::collection('ads')->where('_id', new MongoId($id))->first();
        //     if(!$user) {
        //         return Response::json(array(
        //             'code' => '404',
        //             'message' => 'Not Found'
        //         ), 404);
        //     }
        //     return $user;
        // } else {
        //     return 'Nice try';
        // }
    }

	public function index() {

        //if (Request::ajax()) {
            $ads = LMongo::collection('ads')->where('user_id', Auth::user()->id)->get();
            $result = array();
            foreach ($ads as $key => $value) 
            	array_push($result, $value);
            
            return Response::json($result);
        // }
        // else {
        //     $r = Contact::getContacts();
        //     return View::make('contacts.index');
        // }
    }
    public function update($id) {
    	Cache::forget($id);
        $cat = Input::get('cat');
        $user = LMongo::collection('users')->where('_id', new MongoId(Auth::user()->id) )->first();

		if($cat == "nko" || $cat == "nga") {
			$ad = array(
				'user_id' => Auth::user()->id,
				'title' => Input::get('title'),
				'price' => Input::get('price'),
				'text'	=> Input::get('text'),
				'land_area' => Input::get('land_area'),
				'real_square' => Input::get('real_square'),
				'rooms' => Input::get('rooms'),
				"cat" => $cat,
				'avatar' => $user['avatar']
			);


			$id = LMongo::collection('ads')
                ->where('_id', new MongoId($id))
                ->update($ad);

			//$id = LMongo::collection('ads')->insert($ad);

			return $id;

		}
		if($cat == "aup" || $cat == "aud") {
			$ad = array(
				'user_id' => Auth::user()->id,
				'title' => Input::get('title'),
				'price' => Input::get('price'),
				'text'	=> Input::get('text'),
				'auto_make' => Input::get('auto_make'),
				'auto_model' => Input::get('auto_model'),
				'auto_year' => Input::get('auto_year'),
				'auto_total_mile' => Input::get('auto_total_mile'),
				"cat" => $cat,
				'avatar' => $user['avatar']
			);
			$id = LMongo::collection('ads')
                ->where('_id', new MongoId($id))
                ->update($ad);

			//$id = LMongo::collection('ads')->insert($ad);
			return $id;

		}

    }
	public function store() {
		$cat = Input::get('cat');
		$user = LMongo::collection('users')->where('_id', new MongoId(Auth::user()->id) )->first();


		if($cat == "nko" || $cat == "nga") {
			$ad = array(
				'user_id' => Auth::user()->id,
				'title' => Input::get('title'),
				'price' => Input::get('price'),
				'text'	=> Input::get('text'),
				'land_area' => Input::get('land_area'),
				'real_square' => Input::get('real_square'),
				'rooms' => Input::get('rooms'),
				"cat" => $cat,
				'avatar' => $user['avatar']
			);

			$id = LMongo::collection('ads')->insert($ad);
			return $id;

		}
		if($cat == "aup" || $cat == "aud") {
			$ad = array(
				'user_id' => Auth::user()->id,
				'title' => Input::get('title'),
				'price' => Input::get('price'),
				'text'	=> Input::get('text'),
				'auto_make' => Input::get('auto_make'),
				'auto_model' => Input::get('auto_model'),
				'auto_year' => Input::get('auto_year'),
				'auto_total_mile' => Input::get('auto_total_mile'),
				"cat" => $cat,
				'avatar' => $user['avatar']
			);

			$id = LMongo::collection('ads')->insert($ad);
			return $id;

		}

        //
        return 'error';
    }

}
    