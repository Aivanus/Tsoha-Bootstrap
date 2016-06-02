<?php

class Review extends BaseModel{
	public $id, $reader_id, $book_id, $score, $review_text;

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
				'review_text' => $row['review_text']
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
				'review_text' => $row['review_text']
				));

			return $review;
		}

		return null;
	} 
}