<?php

class Review extends BaseModel{
	public $id, $reader_id, $book_id, $score, $review_text, $reviewed;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Review');
		$query->execute();
		$rows = $query->fetchAll();
		$reviews = array();

		foreach ($rows as $row) {
			$reviews[] = new Review(array(
				'id' => $row['id'],
				'reader_id' => $row['reader_id'],
				'book_id' => $row['book_id'],
				'score' => $row['score'],
				'review_text' => $row['review_text'],
				'reviewed' => $row['reviewed']
			));		
		}

		return $reviews;
	}

	public static function allForBook($id){
		$query = DB::connection()->prepare('SELECT * FROM Review WHERE book_id = :id');
		$query->execute(array('id' => $id));
		$rows = $query->fetchAll();
		$reviews = array();

		foreach ($rows as $row) {
			$reviews[] = new Review(array(
				'id' => $row['id'],
				'reader_id' => $row['reader_id'],
				'book_id' => $row['book_id'],
				'score' => $row['score'],
				'review_text' => $row['review_text'],
				'reviewed' => $row['reviewed']
			));		
		}

		return $reviews;
	}

	public static function find($id){
		$query = DB::connection()->prepare(
			'SELECT * FROM Review WHERE id = :id LIMIT 1'
			);
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$review = new Review(array(
				'id' => $row['id'],
				'reader_id' => $row['reader_id'],
				'book_id' => $row['book_id'],
				'score' => $row['score'],
				'review_text' => $row['review_text'],
				'reviewed' => $row['reviewed']
				));

			return $review;
		}

		return null;
	}

	public function save(){
		$query = DB::connection()->prepare('
			INSERT INTO Review (reader_id, book_id, score, review_text, reviewed) 
				VALUES (:reader_id, :book_id, :score, :review_text, :reviewed) RETURNING id
		');
		$query->execute(array('reader_id' => $this->reader_id, 'book_id' => $this->book_id, 'score' => $this->score, 'review_text' => $this->review_text, 'reviewed' => $this->reviewed));
		$row = $query->fetch();
		$this->id = $row['id'];
	} 
}