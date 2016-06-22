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

	public static function showReview($id){
		$review = Review::find($id);
		View::make('review/read.html', array('review' => $review));
	}

	public static function store(){
		$params = $_POST;
		$user = self::get_user_logged_in();
		//Kint::dump($params);
		$review = new Review(array(
				'reader_id' => $user->id,
				'book_id' => $params['book_id'],
				'score' => $params['score'],
				'review_text' => $params['review'],
				'reviewed' => date("Y-m-d")
			));

		$errors = $review->errors();

		if(count($errors) > 0){
			Redirect::to('/myreviews', array('errors' => $errors));
		}

		$review->save();

		Redirect::to('/myreviews', array('success' => 'Your review was added!'));
	}

	public static function update(){
		$params = $_POST;
		$user = self::get_user_logged_in();
		$review = new Review(array(
				'reader_id' => $user->id,
				'book_id' => $params['book_id'],
				'score' => $params['score'],
				'review_text' => $params['review'],
				'reviewed' => date("Y-m-d")
			));

		$review->update();

		Redirect::to('/myreviews', array('message' => 'Your review was updated!'));
	}

	public static function deleteReview($id){
	    $mybook = new Review(array('id' => $id));
	    $mybook->destroy();

	    Redirect::to('/myreviews', array('message' => 'Review was deleted!'));
  	}
}