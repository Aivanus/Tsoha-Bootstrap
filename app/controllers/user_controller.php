<?php

class UserController extends BaseController{

	public static function login(){
		View::make('user/login.html');
	}

	public static function register(){
		View::make('user/register.html');
	}

	public static function userList(){
		$users = Reader::all();
		//Kint::dump($users);
		View::make('user/user_list.html', array('users' => $users ));
	}

	public static function userPage(){
		View::make('user/user_page.html');
	}

	public static function account(){
		View::make('user/account.html');
	}

	public static function deleteAccount(){
		$user = self::get_user_logged_in();
		$_SESSION['user'] = null;
		$user->destroy();
		Redirect::to('/', array('error' => 'Your account and all information has been deleted!'));
	}

	public static function handle_login(){
	    $params = $_POST;

	    $user = Reader::authenticate($params['username'], $params['password']);


	    if(!$user){
	      View::make('user/login.html', array('error' => 'Invalid username or password!', 'username' => $params['username']));
	    }else{
	      $_SESSION['user'] = $user->id;

	      Redirect::to('/user_page', array('message' => 'Welcome back ' . $user->username . '!'));
    	}
    }

    public static function logout(){
	    $_SESSION['user'] = null;
	    Redirect::to('/login', array('success' => 'Logged out!'));
	}

	public static function changePassword(){
		$params = $_POST;
		$user = self::get_user_logged_in();
		Reader::updatePassword($params['newPassword'], $user->id);

		Redirect::to('/account', array('success' => 'Your password was changed!'));
	}

	public static function createUser(){
		$params = $_POST;
		$reader = new Reader(array(
				'username' => $params['username'],
				'password' => $params['password']
			));

		$errors = $reader->errors();

		if(count($errors) > 0){
			View::make('user/register.html', array('errors' => $errors, 'username' => $params['username']));
		}else{
			$reader->save();

			$reader = Reader::authenticate($params['username'], $params['password']);
			$_SESSION['user'] = $reader->id;

			Redirect::to('/', array('success' => $reader->username.' welcome to Reading List!'));
		}
	}

}