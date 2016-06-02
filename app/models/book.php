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

	public static function find($title, $author){
		$query = DB::connection()->prepare(
			'SELECT * FROM Book 
				WHERE UPPER(title) = UPPER(:title) AND 
				UPPER(author) = UPPER(:author) LIMIT 1'
			);
		$query->execute(array('title' => $title, 'author' => $author));
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