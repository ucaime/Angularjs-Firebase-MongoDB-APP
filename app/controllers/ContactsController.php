<?php

/**
  * ContactsController API class
  *
  * This class handle all API for contacts, 
  * create, edit, view single contact
  *
  * @author     Sardor Isakov
  * @package    ContactsController
  * @param      void
  * @return     void
  */
class ContactsController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Contacts API Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::resource('contact', 'ContactsController');
    |
    */
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
        
            $user_ID = Auth::user()->id;

            $users = LMongo::collection('contacts')->where('user_id', $user_ID)->get();
            $result = array();
            foreach ($users as $key => $value) 
                array_push($result, $value);
            
            return Response::json($result);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
        $clean_name = strtolower(Input::get('name.first')) . "-" . strtolower(Input::get('name.last'));
        $clean_name =  str_replace (" ", "", $clean_name);
        $user_ID = Auth::user()->id;
        $input = array(
                'user_id' => $user_ID,
                'added' => Input::get('added'),
                'email' => Input::get('email'),
                'notes' => Input::get('notes'),
                'number'=> Input::get('number'),
                'clean_name' => $clean_name,
                'name' => array(
                                'first' => Input::get('name.first'),
                                'last'  => Input::get('name.last')
                            )   
        );
        $id = LMongo::collection('contacts')->insert($input);
        if ($id) {
            return $id;
        } else {
            return "Error";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        
            $user = LMongo::collection('contacts')->where('clean_name', $id)->first();
            if(!$user) {
                return Response::json(array(
                    'code' => '404',
                    'message' => 'Not Found'
                ), 404);
            }
            return $user;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        //return Input::all();
        //return LMongo::collection('contacts')->insert(Input::all());
        $clean_name = strtolower(Input::get('name.first')) . "-" . strtolower(Input::get('name.last'));
        $clean_name =  str_replace (" ", "", $clean_name);
        $input = array(
                'added' => Input::get('added'),
                'email' => Input::get('email'),
                'notes' => Input::get('notes'),
                'number'=> Input::get('number'),
                'clean_name' => $clean_name,
                'name' => array(
                                'first' => Input::get('name.first'),
                                'last'  => Input::get('name.last')
                            )   
        );
        $id = LMongo::collection('contacts')
                ->where('clean_name', $id)
                ->update($input);
        if($id) {
            return LMongo::collection('contacts')->where('clean_name', $clean_name)->first();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}