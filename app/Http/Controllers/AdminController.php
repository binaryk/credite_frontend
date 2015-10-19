<?php namespace App\Http\Controllers;

use App\User;
class AdminController extends Controller {

    /**
     * Initializer.
     *
     * @return \AdminController
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(){
        $breadcrumbs = [
            [
            'name' => 'Administration',
            'url'  => "administration",
            'ids' => ''
            ]  
        ];

       return view('administration.index')->with(compact('breadcrumbs'));
    } 


    public function users(){
         $breadcrumbs = [
                [
                'name' => 'Users',
                'url'  => "users-view",
                'ids' => ''
                ]  
        ];
        $users = User::withoutSelf();

       return view('administration.users')->with(compact('breadcrumbs', 'users'));

    } 
}