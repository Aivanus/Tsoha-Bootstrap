<?php

class MyBook extends BaseModel{

	public $id, $reader_id, $book_id, $status, $added, $title, $author;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validate_book_not_in_list');
		$this->title = $this->getTitle();
		$this->author = $this->getAuthor();
	}

	public static function all($user){
		$query = DB::connection()->prepare('SELECT * FROM MyBook WHERE reader_id = :reader_id');
		$query->execute(array('reader_id' => $user->id));
		$rows = $query->fetchAll();
		$mybooks = array();

		foreach ($rows as $row) {
			$mybooks[] = new MyBook(array(
				'id' => $row['id'],
				'reader_id' => $row['reader_id'],
				'book_id' => $row['book_id'],
				'status' => $row['status'],
				'added' => $row['added']
			));		
		}

		return $mybooks;
	}

	public static function find($id){
		$query = DB::connection()->prepare(
			'SELECT * FROM MyBook WHERE id = :id LIMIT 1'
			);
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$mybook = new MyBook(array(
				'id' => $row['id'],
				'reader_id' => $row['reader_id'],
				'book_id' => $row['book_id'],
				'status' => $row['status'],
				'added' => $row['added']
				));

			return $mybook;
		}

		return null;
	} 

	public function getTitle(){
		$query = DB::connection()->prepare(
			'SELECT title FROM Book WHERE id = :id LIMIT 1'
			);
		$query->execute(array('id' => $this->book_id));
		$row = $query->fetch();
		return $row[0];
	}

	public function getAuthor(){
		$query = DB::connection()->prepare(
			'SELECT author FROM Book WHERE id = :id LIMIT 1'
			);
		$query->execute(array('id' => $this->book_id));
		$row = $query->fetch();
		return $row[0];
	}


	public function save(){
		$query = DB::connection()->prepare('INSERT INTO MyBook (reader_id, book_id, status, added) 
			VALUES (:reader_id, :book_id, :status, :added) RETURNING id');
		$query->execute(array('reader_id' => $this->reader_id, 'book_id' => $this->book_id, 'status' => $this->status, 'added' => $this->added));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function destroy(){
		$query = DB::connection()->prepare(
			'DELETE FROM MyBook WHERE id = :id'
			);
		$query->execute(array('id' => $this->id));
	}

	public function update(){

	}

	public function changeStatus(){
		if ($this->status == 0){
			$this->status = 1;
		}else{
			$this->status = 1;
		}
		$query = DB::connection()->prepare('
			UPDATE MyBook SET
				status = :status
				WHERE id = :id
		');
		$query->execute(array('status' => $this->status, 'id' => $this->id));
	}

	public function validate_book_not_in_list(){
		$query = DB::connection()->prepare(
			'SELECT * FROM MyBook WHERE book_id = :book_id AND reader_id = :reader_id LIMIT 1'
			);
		$query->execute(array('book_id' => $this->book_id, 'reader_id' => $this->reader_id));
		$row = $query->fetch();

		if($row){
			return "This book is already on your list!";
		}
	}
}