<?php

class Book extends BaseModel{

	public $id, $title, $author;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Book');
		$query->execute();
		$rows = $query->fetchAll();
		$books = array();

		foreach ($rows as $row) {
			$books[] = new Book(array(
				'id' => $row['id'],
				'title' => $row['title'],
				'author' => $row['author']
			));		
		}

		return $books;
	}

	public static function find($id){
		$query = DB::connection()->prepare(
			'SELECT * FROM Book WHERE id = :id LIMIT 1'
			);
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$book = new Book(array(
				'id' => $row['id'],
				'title' => $row['title'],
				'author' => $row['author']
				));

			return $book;
		}

		return null;
	}
}