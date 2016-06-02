<?php

class MyBook extends BaseModel{

	public $id, $reader_id, $book_id, $status, $added;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM MyBook');
		$query->execute();
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
}