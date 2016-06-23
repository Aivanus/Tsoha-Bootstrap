<?php

class ReviewController extends BaseController{
	
	// Näyttää uuden arvostelun luontisivun
	public static function newReview($id){
		$book = Book::findId($id);
		View::make('review/new.html', array('book' => $book));
	}

	// Näyttää arvostelun muokkaussivun
	public static function editReview($id){
		$review = Review::find($id);
		View::make('review/edit.html', array('review' => $review));
	}

	// Näyttää tiettyyn kirjaan liittyvien arvostelujen listaussivun
	public static function reviewList($id){
		$reviews = Review::all('book_id = :id', array('id' => $id));
		View::make('review/list.html', array('reviews' => $reviews));
	}

	// Näyttää tiettyyn käyttäjän kirjoittamien arvostelujen listaussivun
	public static function myReviews(){
		$user = self::get_user_logged_in();
		$reviews = Review::all('reader_id = :id', array('id' => $user->id));
		View::make('review/my_reviews.html', array('reviews' => $reviews));
	}
	 // Näyttää arvostelun
	public static function showReview($id){
		$review = Review::find($id);
		View::make('review/read.html', array('review' => $review));
	}

	// Funktio, joka tallentaa arvosteluja
	public static function store(){
		$params = $_POST;
		$user = self::get_user_logged_in();
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

	// Päivittää arvostelun sisällön
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

	// Poistaa arvostelun
	public static function deleteReview($id){
	    $mybook = new Review(array('id' => $id));
	    $mybook->destroy();

	    Redirect::to('/myreviews', array('message' => 'Review was deleted!'));
  	}
}