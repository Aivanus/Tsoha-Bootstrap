<?php

class BookController extends BaseController{
	public static function readingList(){
		$mybooks = MyBook::all();
		View::make('mybook/reading_list.html', array('books' => $mybooks)); 
	}

	public static function add_book(){
		View::make('mybook/add_book.html');
	}

	public static function store(){
		$params = $_POST;
		$title = $params['title'];
		$author = $params['author'];
		$search_result = Book::find($title, $author);
		if (!is_null($search_result)) {
			
			$mybook = new MyBook(array(
				'reader_id' => 1,
				'book_id' => $search_result->id,
				'status' => 0,
				'added' => date("Y-m-d")
			));

			$mybook->save();

			Redirect::to('/mybook', array('message' => 'A book was added on your reading list!'));
		}
	}
}