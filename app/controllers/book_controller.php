<?php

class BookController extends BaseController{
	public static function readingList(){
		$user = self::get_user_logged_in();
		$mybooks = MyBook::all($user);
		View::make('mybook/reading_list.html', array('books' => $mybooks)); 
	}

	public static function addBook(){
		View::make('mybook/add_book.html');
	}

	public static function store(){
		$params = $_POST;
		$user = self::get_user_logged_in();
		$title = $params['title'];
		$author = $params['author'];
		$search_result = Book::find($title, $author);
		
		if (!is_null($search_result)) {
			
			$mybook = new MyBook(array(
				'reader_id' => $user->id,
				'book_id' => $search_result->id,
				'status' => 0,
				'added' => date("Y-m-d")
			));

			$errors = $mybook->errors();

			if(count($errors) > 0){
				Redirect::to('/mybook/add_book', array('errors' => $errors, 'attributes' => $params));
			}

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
					'reader_id' => $user->id,
					'book_id' => $new_book->id,
					'status' => 0,
					'added' => date("Y-m-d")
				));

				$errors = $mybook->errors();

				if(count($errors) > 0){
					Redirect::to('/mybook/add_book', array('errors' => $errors, 'attributes' => $params));
				}

				$mybook->save();
			}
		}

		Redirect::to('/book/' . $mybook->book_id, array('success' => $mybook->getTitle().' was added to your reading list!'));
	}

	public static function showBook($id){
		$book = Book::findId($id);
		View::make('book/book_info.html', array('book' => $book));

	}

	public static function listBooks(){
		$books = Book::all();
		View::make('book/book_list.html', array('books' => $books));
	}

	public static function remove_from_list($id){
	    $mybook = new MyBook(array('id' => $id));
	    $mybook->destroy();

	    Redirect::to('/mybook', array('message' => 'Book was removed from your list!'));
  	}

	public static function changeStatus($id){
	  	$mybook = new MyBook(array('id' => $id));
	  	$mybook->changeStatus();

	  	Redirect::to('/mybook', array('success' => 'Status of the book upadated!'));
  	}
}