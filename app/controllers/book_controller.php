<?php

class BookController extends BaseController{
	public static function readingList(){
		$mybooks = MyBook::all();
		View::make('mybook/reading_list.html', array('books' => $mybooks)); 
	}

	public static function add_book(){
		View::make('mybook/add_book.html');
	}
}