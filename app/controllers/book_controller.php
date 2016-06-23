<?php

class BookController extends BaseController{
	
	public static function readingList(){
		$user = self::get_user_logged_in();
		$mybooks = MyBook::all($user);
		View::make('mybook/reading_list.html', array('books' => $mybooks)); 
	}

	// Esittää kirjan lisäämissivun
	public static function addBook(){
		View::make('mybook/add_book.html');
	}

	// Funktio joka tallentaa kirjan lukulistaan. Jos kirjaa ei ole vielä olemassa,
	// se luodaan ja lisätään tietokantaan
	public static function store(){
		$params = $_POST;
		$user = self::get_user_logged_in();
		$bookToAdd = Book::find($params['title'], $params['author']);
		
		if (is_null($bookToAdd)) {
			$bookToAdd = self::createBook($params);
		}else{
			$mybook = new MyBook(array(
				'reader_id' => $user->id,
				'book_id' => $bookToAdd->id,
				'status' => 0,
				'added' => date("Y-m-d")
			));

			$errors = $mybook->errors();

			if(count($errors) > 0){
				Redirect::to('/mybook/add_book', array('errors' => $errors, 'attributes' => $params));
			}

			$mybook->save();
			Redirect::to('/book/' . $mybook->book_id, array('success' => $mybook->getTitle().' was added to your reading list!'));
		}
	}

	// Funktio luo uuden kirjan tietokantaan
	public static function createBook($params){
		$new_book = new Book(array(
				'title' => $params['title'],
				'author' => $params['author']
				));

		$errors = $new_book->errors();

		if(count($errors) > 0){
			Redirect::to('/mybook/add_book', array('errors' => $errors, 'attributes' => $params));
		}else{
			$new_book->save();
			return $new_book;
		}
	}

	// Funktio näyttää kirjan ifosivun
	public static function showBook($id){
		$book = Book::findId($id);
		View::make('book/book_info.html', array('book' => $book));

	}

	// Funktio näyttää kaikkien kirjojen listaussivun
	public static function listBooks(){
		$books = Book::all();
		View::make('book/book_list.html', array('books' => $books));
	}

	// Funktio, joka osallistuu kirjan poistamiseen lukulistalta
	public static function remove_from_list($id){
	    $mybook = new MyBook(array('id' => $id));
	    $mybook->destroy();
	    Redirect::to('/mybook', array('message' => 'Book was removed from your list!'));
  	}

  	// Funktio, joka osallistuu kirjan muuttamiseen luetuksi
	public static function changeStatus($id){
	  	$mybook = new MyBook(array('id' => $id));
	  	$mybook->changeStatus();
	  	Redirect::to('/mybook', array('success' => 'Status of the book upadated!'));
  	}
}