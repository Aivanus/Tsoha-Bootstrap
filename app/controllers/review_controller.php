<?php

class ReviewController extends BaseController{
	
	public static function newReview($id){
		$book = Book::findId($id);
		View::make('review/new.html', array('book' => $book));
	}

	public static function editReview($id){
		$review = Review::find($id);
		View::make('review/edit.html', array('review' => $review));
	}

	public static function reviewList($id){
		$reviews = Review::allForBook($id);
		View::make('review/list.html', array('reviews' => $reviews));
	}

	public static function myReviews(){
		$user = self::get_user_logged_in();
		$reviews = Review::allForUser($user->id);
		View::make('review/my_reviews.html', array('reviews' => $reviews));
	}

	public static function store(){
		$params = $_POST;
		Kint::dump($params);
		$review = new Review(array(
				'reader_id' => 1,
				'book_id' => $params['book_id'],
				'score' => $params['score'],
				'review_text' => $params['review'],
				'reviewed' => date("Y-m-d")
			));

		$review->save();

		Redirect::to('/book/'.$review->book_id, array('message' => 'Your review was added!'));
	}

	public static function update($id){
		$params = $_POST;
		Kint::dump($params);
		$review = new Review(array(
				'reader_id' => $id,
				'book_id' => $params['book_id'],
				'score' => $params['score'],
				'review_text' => $params['review'],
				'reviewed' => date("Y-m-d")
			));

		$review->update();

		Redirect::to('/myreviews', array('message' => 'Your review was updated!'));
	}
}