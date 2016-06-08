<?php

class BookController extends BaseController{
	public static function readingList(){
		$mybooks = MyBook::all();
		View::make('mybook/reading_list.html', array('books' => $mybooks)); 
	}

	public static function addBook(){
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

		}else{
			$new_book = new Book(array(
				'title' => $title,
				'author' => $author
				));

			$errors = $new_book->errors();

			if(count($errors) > 0){
				Redirect::to('/mybook/add_book', array('errors' => $errors, 'attributes' => $params));
			}else{

				$new_book->save();

				$mybook = new MyBook(array(
					'reader_id' => 1,
					'book_id' => $new_book->id,
					'status' => 0,
					'added' => date("Y-m-d")
				));

				$mybook->save();
				}
		}

		Redirect::to('/book/' . $mybook->book_id, array('message' => 'A book was added on your reading list!'));
	}

	public static function showBook($id){
		$book = Book::findId($id);
		View::make('book/book_info.html', array('book' => $book));

	}
}