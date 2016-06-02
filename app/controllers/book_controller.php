<?php

class BookController extends BaseController{
	public static function index(){
		$mybooks = MyBook::all();
		View::make('mybook/index.html', array('books' => $mybooks)); 
	}
}