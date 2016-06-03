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

	public static function findId($id){
		$query = DB::connection()->prepare('
			SELECT * FROM Book WHERE id = :id LIMIT 1
			');
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

	public function getRating(){
		$query = DB::connection()->prepare('
			SELECT ROUND(AVG(score), 1) FROM Book 
				LEFT JOIN Review ON Book.id = Review.book_id 
				WHERE Book.id = :id;
		');
		$query->execute(array('id' => $this->id));
		$row = $query->fetch();
		return $row[0];
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Book (title, author) 
			VALUES (:title, :author) RETURNING id');
		$query->execute(array('title' => $this->title, 'author' => $this->author));
		$row = $query->fetch();
		$this->id = $row['id'];
	}
}