<?php

class ReviewController extends BaseController{
	public static function newReview($id){
		$book = Book::findId($id);
		View::make('review/new.html', array('book' => $book));
	}

	public static function store(){
		$params = $_POST;
		Kint::dump($params);
		$review = new Review(array(
				'reader_id' => 1,
				'book_id' => $params['book_id'],
				'score' => $params['score'],
				'review_text' => $params['review']
			));

		$review->save();

		Redirect::to('/book/'.$review->book_id, array('message' => 'Your review was added!'));
	}
}