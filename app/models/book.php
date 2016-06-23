<?php

class Book extends BaseModel{

	public $id, $title, $author;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validate_title', 'validate_author');
	}

	// Hakee kaikki kirjat tietokannasta ja järjestää ne aakkosjärjestykseen
	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Book ORDER BY Book.title');
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

	// Hakee tietokannasta kirjan, jolla on tietty nimi ja kirjoittaja
	public static function find($title, $author){
		$query = DB::connection()->prepare(
			'SELECT * FROM Book 
				WHERE UPPER(title) = UPPER(:title) AND 
				UPPER(author) = UPPER(:author) LIMIT 1'
			);
		$query->execute(array('title' => trim($title), 'author' => trim($author)));
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

	// Hakee tietokannasta kirjan, id:n perusteella
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

	// Laskee ja palauttaa kirjan arvostelujen keskiarvon
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

	// Tallentaa kirjan
	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Book (title, author) 
			VALUES (:title, :author) RETURNING id');
		$query->execute(array('title' => trim($this->title), 'author' => trim($this->author)));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	// Validointifunktiot
	public function validate_title(){
		return parent::validate_field_not_null($this->title, 'Title cannot be empty!');
	}

	public function validate_author(){
		return parent::validate_field_not_null($this->author, 'Author cannot be empty!');
	}
}