<?php

class HomeController extends \BaseController {

	public function __construct()
    {
        //$this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

        // $this->afterFilter('log', array('only' =>
        //                     array('fooAction', 'barAction')));
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		

		if (Input::has('category')) {
			$category = Input::get('category');
		   $ads = LMongo::collection('ads')->where('cat', $category )->get();
		   return View::make('home', array('ads' => $ads, 'user_name' => 'Sardor I'));
		}
		$ads = LMongo::collection('ads')->get();
		return View::make('home', array('ads' => $ads, 'user_name' => 'Sardor I'));
	}

}