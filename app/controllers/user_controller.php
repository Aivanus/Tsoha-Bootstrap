<?php

class UserController extends BaseController{

	public static function login(){
		View::make('user/login.html');
	}

	public static function register(){
		View::make('user/register.html');
	}

	public static function handle_login(){
	    $params = $_POST;

	    $user = Reader::authenticate($params['username'], $params['password']);


	    if(!$user){
	      View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
	    }else{
	      $_SESSION['user'] = $user->id;

	      Redirect::to('/', array('message' => 'Welcome back ' . $user->username . '!'));
    	}
    }

    public static function logout(){
	    $_SESSION['user'] = null;
	    Redirect::to('/login', array('success' => 'Logged out!'));
	}

	public static function createUser(){
		$params = $_POST;
		$reader = new Reader(array(
				'username' => $params['username'],
				'password' => $params['password']
			));

		$reader->save();

		$reader = Reader::authenticate($params['username'], $params['password']);
		$_SESSION['user'] = $reader->id;

		Redirect::to('/', array('success' => $reader->username.' welcome to Reading List!'));
	}

}